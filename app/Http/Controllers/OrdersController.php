<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Book;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Exception;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class OrdersController extends Controller
{
	protected $credentials;
	
	public function __construct() {
		$this->credentials = [
			'mode'    => (setting('app.paypal.sandbox')) ? 'sandbox' : 'live',
			'sandbox' => [
				'client_id'         => setting('app.paypal.client-id'),
				'client_secret'     => setting('app.paypal.secret'),
				'app_id'            => '',
			],
			'live' => [
				'client_id'         => setting('app.paypal.client-id'),
				'client_secret'     => setting('app.paypal.secret'),
				'app_id'            => '',
			],
			'payment_action' => 'Sale',
			'currency'       => 'EUR',
			'notify_url'     => '',
			'locale'         => '',
			'validate_ssl'   => true,
		];
	}

    public function list() {
		$orders = Order::with('books')->orderBy('created_at', 'DESC')->get();
		return view('orders.list', compact('orders'));
	}

	public function display($orderId) {
		$order = Order::with('books')->where('order_id', $orderId)->first();
		return view('orders.display', compact('order'));
	}

	public function paypal(Request $request, float $shippingCost = 0) {

		if($shippingCost <= 0) {
			return response()->json()->setStatusCode(500, 'No shipping price found');
		}

		if(!$request->session()->has('cart')) {
			return response()->json()->setStatusCode(500, 'Cart not found');
		}

		// CART
		$cart = $request->session()->get('cart', false);
		$booksInCart = Book::findMany(array_keys($cart));

		// PAYPAL
		$provider = new PayPalClient;
		$provider->setApiCredentials($this->credentials);
		$provider->getAccessToken();

		// ITEMS
		$total = array_reduce($cart, function($total, $item) {
			return $total + ($item['price'] * $item['quantity']);
		}, $shippingCost);

		$items = [];
		if($booksInCart) {
			$booksInCart->each(function($book) use ($cart, $items) {
				array_push($items, [
					'name' => $book->title,
					'unit_amount' => $book->price,
					'quantity' => $cart[$book->id]['quantity'],
				]);
			});
		}

		// ORDER
		$order = $provider->createOrder([
			'intent' => 'CAPTURE',
			'purchase_units' => [
				0 => [
					'amount' => [
						'currency_code'=> 'EUR',
						'value' => $total,
					],
					'items' => $items
				]
			]
		]);
		
		// Inserting order in our internal datbase
		$newOrder = Order::create([
			'order_id' => $order['id'],
			'status' => $order['status'],
		]);

		// Attaching books from cart to Order
		$booksInCart->each(function($book) use(&$newOrder, $cart) {
			$newOrder->books()->attach($book->id, ['quantity' => $cart[$book->id]['quantity']]);
		});

		// Updating books quantity
		$booksInCart->each(function($book) use ($cart) {
			$book->quantity = $book->quantity - $cart[$book->id]['quantity'];
			$book->save();
		});

		return $order;
	}

	public function capture(Request $request) {
		$data = json_decode($request->getContent());
		//dump($data);
		if(isset($data->status) && $data->status == 'COMPLETED') {
			try {
				$order = Order::where('order_id', $data->id)->first();
				$order->transaction_id = $data->purchase_units[0]->payments->captures[0]->id;
				$order->payer_id = $data->payer->payer_id;
				$order->surname = $data->payer->name->surname;
				$order->given_name = $data->payer->name->given_name;
				$order->full_name = $data->purchase_units[0]->shipping->name->full_name;
				$order->email_address = $data->payer->email_address;
				$order->address_line_1 = $data->purchase_units[0]->shipping->address->address_line_1;
				//$order->address_line_2 = $data->purchase_units[0]->shipping->address->address_line_2;
				$order->address_line_2 = (property_exists($data->purchase_units[0]->shipping->address, 'address_line_2')) ? $data->purchase_units[0]->shipping->address->address_line_2 : null;
				$order->admin_area_2 = $data->purchase_units[0]->shipping->address->admin_area_2;
				$order->admin_area_1 = $data->purchase_units[0]->shipping->address->admin_area_1;
				$order->postal_code = $data->purchase_units[0]->shipping->address->postal_code;
				$order->country_code = $data->purchase_units[0]->shipping->address->country_code;
				$order->status = $data->status;
				$order->save();

				// Emptying Cart
				$request->session()->forget('cart');

				return $request->getContent();
			} catch(Exception $e) {

				if(
					property_exists($data, 'purchase_units') &&
					isset($data->purchase_units[0]) &&
					property_exists($data->purchase_units[0], 'payments') &&
					property_exists($data->purchase_units[0]->payments, 'captures') &&
					isset($data->purchase_units[0]->payments->captures[0]) &&
					property_exists($data->purchase_units[0]->payments->captures[0], 'id') 
				) {
					$transactionId = $data->purchase_units[0]->payments->captures[0]->id;
				} else {
					$transactionId = 'TransactionID not found.';
				}
				
				if(property_exists($data, 'id')) {
					$orderId = $data->id;
					$order = Order::where('order_id', $data->id)->first();
					$order->status = 'FAILED';
					if($transactionId != 'TransactionID not found.') {
						$order->transaction_id = $transactionId;
					}
					$order->save();
				} else {
					$orderId = 'OrderID not found. This is a critical issue meaning paypal data might not have been forwarded to capture function. Order might still be pending with CREATED status whereas client has successfully paid.';
				}

				$customMessage = 'Paypal data doesn\'t match Order Model';
				$fullMessage = $customMessage."\n\t".
					'in file '.$e->getFile().' at line '.$e->getLine()."\n\t".
					'Message : '.$e->getMessage()."\n\t".
					'OrderID : '.$orderId."\n\t".
					'TransactionID : '.$transactionId."\n\n";

				Log::channel('paypal')->critical($fullMessage);

				//TODO Send a mail or a notification here to admins

				return ['error' => [
					'code' => $e->getCode(),
					'file' => $e->getFile(),
					'line' => $e->getLine(),
					'message' => $e->getMessage(),
					'custom-message' => $customMessage,
					'paypal-data' => $data,
					//'trace' => $e->getTrace(),
				]];
			}
		}
	}

	public function checkCountry(Request $request, $countryCode) {
		return (in_array($countryCode, setting('app.shipping.allowed-countries')))
			? ''
			: response()->json()->setStatusCode(500, 'Country code not accepted by the store.');
	}

	public function cancel($orderId) {
		// Getting order to cancel
		$order = Order::with('books')->where('order_id', $orderId)->first();

		// Reinserting quantities in stock
		$order->books()->each(function($book) {
			$book->quantity = $book->quantity + $book->pivot->quantity;
			$book->save();
		});

		// Detaching books
		$order->books()->detach();

		// Deleting order
		$order->delete();
	}

	public function details($orderId) {

		$provider = new PayPalClient;
		$provider->setApiCredentials($this->credentials);
		$provider->getAccessToken();

		$details = $provider->showOrderDetails($orderId);

		return $details;	
	}

	public function recycle($orderId) {
		$details = $this->details($orderId);
		if(isset ($details['type']) && $details['type'] == 'error') {
			$this->cancel($orderId);
			return redirect()->route('orders');
		} else {
			return redirect()->route('orders')->with([
				'flash' => __('flash.paypal.recycle'),
				'flash-type' => 'warning'
			]);;
		}
		
	}

}
