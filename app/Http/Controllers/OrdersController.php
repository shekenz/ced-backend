<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Book;
use App\Models\User;
use App\Models\ShippingMethod;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\SystemError;

class OrdersController extends Controller
{
	protected $credentials;
	protected $provider;
	
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
		$this->provider = new PayPalClient;
		$this->provider->setApiCredentials($this->credentials);
		$this->provider->getAccessToken();
	}
    
    /**
     * list
     *
     * @return void
     */
    public function list() {
		$orders = Order::with('books')->orderBy('created_at', 'DESC')->get();
		return view('orders.list', compact('orders'));
	}
	
	/**
	 * display
	 *
	 * @param  mixed $id
	 * @return void
	 */
	public function display($id) {
		$order = Order::with('books')->where('id', $id)->first();
		return view('orders.display', compact('order'));
	}

		
	/**
	 * createOrder
	 *
	 * @param  mixed $request
	 * @param  mixed $shippingCost
	 * @return void
	 */
	public function createOrder(Request $request, ShippingMethod $shippingMethod) {
		
		if(!$request->session()->has('cart')) {
			Log::channel('paypal')->notice('Cart not found');
			return response()->json()->setStatusCode(404, 'Cart not found');
		}

		// CART
		$cart = $request->session()->get('cart', false);
		$booksInCart = Book::findMany(array_keys($cart));

		// ITEMS
		$total = array_reduce($cart, function($total, $item) {
			return $total + ($item['price'] * $item['quantity']);
		}, $shippingMethod->price);

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
		$paypalOrder = $this->provider->createOrder([
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
			$order = Order::create([
				'order_id' => $paypalOrder['id'],
				'status' => $paypalOrder['status'],
				'shipping_method' => $shippingMethod->label,
				'shipping_price' => $shippingMethod->price,
			]);
		} catch(Exception $e) {
			$order = Order::create([
				'status' => 'FAILED',
				'shipping_method' => $shippingMethod->label,
				'shipping_price' => $shippingMethod->price,
			]);
			
			$customMessage = 'Can\'t create order! The Esteban error!';
			$fullMessage = $customMessage."\n\t".
				'in file '.$e->getFile().' at line '.$e->getLine()."\n\t".
				'Called by : createOrder'."\n\t".
				'Message : '.$e->getMessage()."\n\t".
				'Data : --------------------------------'."\n".
				print_r($paypalOrder, true);

			// Loggin error
			Log::channel('paypal')->critical($fullMessage);

			// Sending error email to admins
			$admins = User::where('role', 'admin')->get();
			$admins->each(function($admin) use($customMessage, $e, $paypalOrder) {
				Mail::to($admin->email)->send(new SystemError($customMessage, $e, $paypalOrder));
			});

			$errorResponse = (config('env') == 'local') ? ['error' => [
				'type' => 'internal',
				'file' => $e->getFile(),
				'line' => $e->getLine(),
				'message' => $e->getMessage(),
				'custom-message' => $customMessage,
				'paypal-data' => $paypalOrder,
			]] : [];

		} finally {

			// Attaching books from cart to Order
			$booksInCart->each(function($book) use(&$order, $cart) {
				$order->books()->attach($book->id, ['quantity' => $cart[$book->id]['quantity']]);
			});

			// Updating books quantity
			$booksInCart->each(function($book) use ($cart) {
				$book->quantity = $book->quantity - $cart[$book->id]['quantity'];
				$book->save();
			});

			return (isset($errorResponse)) ? response()->json($errorResponse)->setStatusCode(500, 'Paypal order creation failed') : $paypalOrder;
		}
	}
	
	/**
	 * capture
	 *
	 * @param  mixed $request
	 * @param  mixed $orderID
	 * @return void
	 */
	public function capture(Request $request, $orderID) {
		$paypalOrder = $this->provider->capturePaymentOrder($orderID);
		try{
			if(!isset($paypalOrder['error'])) {
				// process order
				$order = Order::where('order_id', $paypalOrder['id'])->first();

				// Check those optional fields, log if empty
				if(!empty($paypalOrder['payer']['name']['surname'])) {
					$order->surname = $paypalOrder['payer']['name']['surname'];
				} else {
					Log::channel('paypal')->critical('Can\'t read property "surname" from Paypal data for orderID '.$paypalOrder['id']);
				}
				if(!empty($paypalOrder['payer']['name']['given_name'])) {
					$order->given_name = $paypalOrder['payer']['name']['given_name'];
				} else {
					Log::channel('paypal')->critical('Can\'t read property "given_name" from Paypal data for orderID '.$paypalOrder['id']);
				}
				if(!empty($paypalOrder['purchase_units'][0]['shipping']['name']['full_name'])) {
					$order->full_name = $paypalOrder['purchase_units'][0]['shipping']['name']['full_name'];
				} else {
					Log::channel('paypal')->critical('Can\'t read property "full_name" from Paypal data for orderID '.$paypalOrder['id']);
				}

				// Check if optional address fields exists in paypal data, log if empty
				$shippingAddressFields = [
					'address_line_1',
					'address_line_2',
					'admin_area_2',
					'admin_area_1', 
					'postal_code',
					'country_code'
				];
				foreach($shippingAddressFields as $columnName) {
					if(!empty($paypalOrder['purchase_units'][0]['shipping']['address'][$columnName])) {
						$order->{$columnName} = $paypalOrder['purchase_units'][0]['shipping']['address'][$columnName];
					} else {
						Log::channel('paypal')->notice('Can\'t read property "'.$columnName.'" from Paypal data for orderID '.$paypalOrder['id']);
					}
				}

				try {
					// Crutial data, trigger exception if not found	in paypal data
					$order->status = $paypalOrder['status'];			
					$order->payer_id = $paypalOrder['payer']['payer_id'];
					$order->email_address = $paypalOrder['payer']['email_address'];
					$order->transaction_id = $paypalOrder['purchase_units'][0]['payments']['captures'][0]['id'];

				} catch(Exception $e) { 

					$transactionId = (isset($paypalOrder['purchase_units'][0]['payments']['captures'][0]['id'])) ? $paypalOrder['purchase_units'][0]['payments']['captures'][0]['id'] : 'TransactionID not found.';
					$order->status = 'FAILED';
					$order->transaction_id = $transactionId;

					$customMessage = 'Paypal data doesn\'t match Order Model mendatory data';
					$fullMessage = $customMessage."\n\t".
						'in file '.$e->getFile().' on line '.$e->getLine()."\n\t".
						'Called by : onApprouve'."\n\t".
						'Message : '.$e->getMessage()."\n\t".
						'OrderID : '.$paypalOrder['id']."\n\t".
						'TransactionID : '.$transactionId;

					Log::channel('paypal')->critical($fullMessage);

					// Sending error email to admins
					$admins = User::where('role', 'admin')->get();
					$admins->each(function($admin) use($customMessage, $e, $paypalOrder) {
						Mail::to($admin->email)->send(new SystemError($customMessage, $e, $paypalOrder));
					});

					$errorResponse = (config('env') == 'local') ? ['error' => [
						'type' => 'internal',
						'file' => $e->getFile(),
						'line' => $e->getLine(),
						'message' => $e->getMessage(),
						'custom-message' => $customMessage,
						'paypal-data' => $paypalOrder,
					]] : [];
				
				} finally {
					// Saving order in database
					$order->save();
				}

			} else {
				Throw new Exception($paypalOrder['error']['name']);
			}
		} catch(Exception $e) {
			$errorLog = 'Paypal order capture responded with an error : '.$e->getMessage()."\n".
			'Details :'."\n";
			foreach($paypalOrder['error']['details'] as $value) {
				$errorLog .= "\t".$value['issue'].' : '.$value['description'];
			}

			Log::channel('paypal')->critical($errorLog);
			$admins = User::where('role', 'admin')->get();
			$admins->each(function($admin) use($orderID, $e, $paypalOrder) {
				Mail::to($admin->email)->send(new SystemError('Paypal order '.$orderID.' capture failed', $e, $paypalOrder));
			});

			$errorResponse = $paypalOrder;

		} finally {
			// Emptying Cart
			$request->session()->forget('cart');
			
			return (isset($errorResponse)) ? response()->json($errorResponse)->setStatusCode(500, 'Paypal order processing failed') : $paypalOrder;
		}
	}
	
	/**
	 * checkCountry
	 *
	 * @param  mixed $request
	 * @param  mixed $countryCode
	 * @return void
	 */
	public function checkCountry(Request $request, $countryCode) {
		return (in_array($countryCode, setting('app.shipping.allowed-countries')) || empty(setting('app.shipping.allowed-countries')))
			? [ 'country' => true ]
			: response()->json()->setStatusCode(500, 'Country code not accepted by the store.');
	}
	
	/**
	 * cancel
	 *
	 * @param  mixed $orderID
	 * @return void
	 */
	public function cancel($orderID) {
		// Getting order to cancel
		$order = Order::with('books')->where('order_id', $orderID)->first();

		try {
			// Reinserting quantities in stock
			$order->books()->each(function($book) {
				$book->quantity = $book->quantity + $book->pivot->quantity;
				$book->save();
			});
			// Detaching books
			$order->books()->detach();
			// Deleting order
			$order->delete();

		} catch(Exception $e) {
			
			$customMessage = 'Can\'t delete order';
			$fullMessage = $customMessage."\n\t".
				'in file '.$e->getFile().' on line '.$e->getLine()."\n\t".
				'Message : '.$e->getMessage()."\n\t".
				'OrderID : '.$orderID;

			Log::channel('paypal')->critical($fullMessage);

			// Sending error email to admins
			$admins = User::where('role', 'admin')->get();
			$admins->each(function($admin) use($customMessage, $e, $order) {
				Mail::to($admin->email)->send(new SystemError($customMessage, $e, $order));
			});

			$errorResponse = true;

		} finally {
			return (isset($errorResponse)) ? response()->json()->setStatusCode(500, 'Can\'t delete order') : [ 'deleted' => $orderID ];
		}
		
	}
	
	/**
	 * details
	 *
	 * @param  mixed $orderID
	 * @return void
	 */
	public function details($orderID) {

		$details = $this->provider->showOrderDetails($orderID);

		return $details;	
	}
	
	/**
	 * recycle
	 *
	 * @param  mixed $orderID
	 * @return void
	 */
	public function recycle($orderID) {
		$details = $this->details($orderID);
		if(isset($details['error'])) {
			$this->cancel($orderID);
			return redirect()->route('orders');
		} else {
			return redirect()->route('orders')->with([
				'flash' => __('flash.paypal.recycle'),
				'flash-type' => 'warning'
			]);;
		}	
	}
	
	/**
	 * shipped
	 *
	 * @param  mixed $orderID
	 * @return void
	 */
	public function shipped($orderID) {
		$order = Order::where('order_id', $orderID)->first();
		if($order->status == 'COMPLETED') {
			$order->status = 'SHIPPED';
		} else {
			$order->status = 'COMPLETED';
		}
		
		$order->save();
		return back();
	}

}
