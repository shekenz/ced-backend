<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Book;
use App\Models\User;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\SystemError;

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

	public function createOrder(Request $request, float $shippingCost = 0) {

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

		try {
			$newOrder = Order::create([
				'order_id' => $order['id'],
				'status' => $order['status'],
			]);
		} catch(Exception $e) {
			$newOrder = Order::create([
				'status' => 'FAILED',
			]);
			
			$customMessage = 'Can\'t create order! The Esteban error';
			$fullMessage = $customMessage."\n\t".
				'in file '.$e->getFile().' at line '.$e->getLine()."\n\t".
				'Called by : createOrder'."\n\t".
				'Message : '.$e->getMessage()."\n\t".
				'Data : --------------------------------'."\n".
				print_r($order, true);

			// Loggin error
			Log::channel('paypal')->critical($fullMessage);

			// Sending error email to admins
			$admins = User::where('role', 'admin')->get();
			$admins->each(function($admin) use($customMessage, $e, $order) {
				Mail::to($admin->email)->send(new SystemError($customMessage, $e, $order));
			});

		}
		

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
		if(isset($data->id)) {

			$order = Order::where('order_id', $data->id)->first();

			try {

				// Crutial data, trigger exception if not found	in paypal data
				$order->status = $data->status;			
				$order->payer_id = $data->payer->payer_id;
				$order->email_address = $data->payer->email_address;
				$order->transaction_id = $data->purchase_units[0]->payments->captures[0]->id;

				// Optional data
				$order->surname = (isset($data->payer->name->surname)) ? $data->payer->name->surname : null;
				$order->given_name = (isset($data->payer->name->given_name)) ? $data->payer->name->given_name : null;
				$order->full_name = (isset($data->purchase_units[0]->shipping->name->full_name)) ? $data->purchase_units[0]->shipping->name->full_name : null;
				$order->address_line_1 = (isset($data->purchase_units[0]->shipping->address->address_line_1)) ? $data->purchase_units[0]->shipping->address->address_line_1 : null;
				$order->address_line_2 = (isset($data->purchase_units[0]->shipping->address->address_line_2)) ? $data->purchase_units[0]->shipping->address->address_line_2 : null;
				$order->admin_area_2 = (isset($data->purchase_units[0]->shipping->address->admin_area_2)) ? $data->purchase_units[0]->shipping->address->admin_area_2 : null;
				$order->admin_area_1 = (isset($data->purchase_units[0]->shipping->address->admin_area_1)) ? $data->purchase_units[0]->shipping->address->admin_area_1 : null;
				$order->postal_code = (isset($data->purchase_units[0]->shipping->address->postal_code)) ? $data->purchase_units[0]->shipping->address->postal_code : null;
				$order->country_code = (isset($data->purchase_units[0]->shipping->address->country_code)) ? $data->purchase_units[0]->shipping->address->country_code : null;
				
				$order->save();

				// Emptying cart
				$request->session()->forget('cart');

				return $request->getContent();

			} catch(Exception $e) { // In case paypal didn't send excpected data

				$transactionId = (isset($data->purchase_units[0]->payments->captures[0]->id)) ? $data->purchase_units[0]->payments->captures[0]->id : 'TransactionID not found.';
				$order->status = 'FAILED';
				$order->transaction_id = $transactionId;
				
				$order->save();

				$customMessage = 'Paypal data doesn\'t match Order Model';
				$fullMessage = $customMessage."\n\t".
					'in file '.$e->getFile().' at line '.$e->getLine()."\n\t".
					'Called by : onApprouve'."\n\t".
					'Message : '.$e->getMessage()."\n\t".
					'OrderID : '.$data->id."\n\t".
					'TransactionID : '.$transactionId."\n\n";

				Log::channel('paypal')->critical($fullMessage);

				// Sending error email to admins
				$admins = User::where('role', 'admin')->get();
				$admins->each(function($admin) use($customMessage, $e, $data) {
					Mail::to($admin->email)->send(new SystemError($customMessage, $e, $data));
				});

				// Emptying Cart
				$request->session()->forget('cart');

				return ['error' => [
					'code' => $e->getCode(),
					'file' => $e->getFile(),
					'line' => $e->getLine(),
					'message' => $e->getMessage(),
					'custom-message' => $customMessage,
					'paypal-data' => $data,
				]];
			}
		} else {
			$e = new Exception('No ID found in $data');
			Log::channel('paypal')->critical('Error : '.$e->getMessage());
			// Sending error email to admins
			$admins = User::where('role', 'admin')->get();
			$admins->each(function($admin) use($e, $data) {
				Mail::to($admin->email)->send(new SystemError('Cannot process onApprouve data', $e, $data));
			});
			return ['error' => $e->getMessage()];
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
