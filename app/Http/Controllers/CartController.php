<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Order;
use App\Http\Helpers\CartHelper;

class CartController extends Controller
{
	protected $validation = [
		'lastname' => ['required', 'string', 'max:64'],
		'firstname' => ['required', 'string', 'max:64'],
		'company' => ['nullable', 'string', 'max:64'],
		'phone' => ['required', 'string'],
		'email' => ['required', 'email'],
		'shipping-address-1' => ['required', 'string', 'max:128'],
		'shipping-address-2' => ['nullable', 'string', 'max:128'],
		'shipping-city' => ['required', 'string', 'max:96'],
		'shipping-postcode' => ['required', 'string'],
		'shipping-country' => ['required', 'string'],
		'invoice-address-1' => ['required', 'string', 'max:128'],
		'invoice-address-2' => ['nullable', 'string', 'max:128'],
		'invoice-city' => ['required', 'string', 'max:96'],
		'invoice-postcode' => ['required', 'string'],
		'invoice-country' => ['required', 'string'],
		'sale-conditions' => ['accepted'],
	];

	protected function redirectIfEmpty() {
		if(CartHelper::isEmpty()) {
			return redirect(route('index'));
		} else {
			return back();
		}
	}

	protected function abortByRequestMethod(Request $request, $errorCode = 400, $errorMessage = '') {
		if($request->isMethod('POST')) {
			return response()->json()->setStatusCode($errorCode, $errorMessage);
		} else {
			return abort($errorCode, $errorMessage);
		}
	}

	// Better if it was a trait or helper //TODO
	public function updateCart() {

		$cart = session()->get('cart', false);

		if($cart) {
			// Find all books from cart without archived books (In 1 call)
			$books = Book::with([
				'media' => function($q) { $q->orderBy('pivot_order', 'asc'); }
			])->findMany(array_keys($cart));

			// Filter out if books has no price or no media
			$books = $books->filter(function($book) {
				return ($book->media->isNotEmpty() && isset($book->price));
			});

			// remap $books collection with books id as key
			$books = $books->keyBy('id');

			// Update cart according to filtered books array
			// In case book has been removed or is not available for sale while in client's cart
			$articleUpdated = (count($cart) - $books->count() > 0);
			$cart = array_intersect_key($cart, $books->toArray());

			// Check stock limits
			$quantityUpdated = false;
			array_walk($cart, function(&$article, $id) use ($books, &$quantityUpdated) {
				$stock = intval($books[$id]->quantity);
				if($article['quantity'] > $stock) {
					$article['quantity'] = $stock;
					$quantityUpdated = true;
				}
			});

			// Updates $books cartQuantity
			$books->each(function($book, $id) use ($cart) {
				$book->cartQuantity = $cart[$id]['quantity'];
			});

			// Update session cart
			session(['cart' => $cart]);

			return [
				'books' => compact('books'),
				'updated' => ($articleUpdated || $quantityUpdated),
			];
		} else {
			return false;
		}
	}

    public function viewCart(Request $request) {
		$cart = $request->session()->get('cart', false);
		$cartValidation = $this->updateCart($cart);

		if($cartValidation) {
			// Redirect with flash if needed
			if($cartValidation['updated']) {
				session()->now('flash', __('flash.cart.stockUpdated'));
				session()->now('flash-type', 'warning');
				return view('index.cart.cart', $cartValidation['books']);
			} else {
				return view('index.cart.cart',  $cartValidation['books']);
			}

		} else {
			return view('index.cart.cart');
		}
		
	}

	public function add(request $request, $id) {

		$book = Book::with('media')->findOrFail($id);
		$bookReturnedDetails = [
			'book' => [
				'id' => $book->id,
				'price' => $book->price,
				'modifier' => 1
			]
		];

		// If book has no price or has no media, you shouldn't be here
		if(!isset($book->price) || $book->media->isEmpty()) {
			return $this->abortByRequestMethod($request, 400, 'Book not available');
		}

		// If cart is empty, create new cart array
		if(CartHelper::isEmpty()) {
			$cart = [];
		} else { // or retrieve existing cart
			$cart = session('cart');
		}
		
		// If book id found in cart, just update quantity
		if(array_key_exists($book->id, $cart)) {
			if($cart[$book->id]['quantity'] < $book->quantity) { // Check for stock
				$cart[$book->id]['quantity'] += 1;
			} else { // Redirect and inform the user book is not in stock anymore
				// Needs refractoring -------------------------------------------------------- // TODO
				if ($request->isMethod('post')) {
					return response()->json($bookReturnedDetails)->setStatusCode(500, __('flash.cart.stockLimit'));
				} else {
					return back()->with([
						'flash' => __('flash.cart.stockLimit'),
						'flash-type' => 'warning',
					]);
				}
			}
		} else { // Else push new book id with an array with quantity of 1 and price
			if($book->quantity > 0) { // Check for stock
				$cart[$book->id] = [ 'price' => $book->price, 'quantity' => 1];
			} else {
				// Needs refractoring -------------------------------------------------------- // TODO
				if ($request->isMethod('post')) {
					return response()->json($bookReturnedDetails)->setStatusCode(500, __('flash.cart.stockLimit'));
				} else {
					return back()->with([
						'flash' => __('flash.cart.stockLimit'),
						'flash-type' => 'warning',
					]);
				}
			}
		}

		// Save new cart in sesh and redirect
		session(['cart' => $cart]);
		if ($request->isMethod('post')) {
			return response()->json($bookReturnedDetails);
		} else {
			return back();
		}
	}

	public function remove(Request $request, $id) {

		$book = Book::with('media')->findOrFail($id);
		$bookReturnedDetails = [
			'book' => [
				'id' => $book->id,
				'price' => $book->price,
				'modifier' => -1
			]
		];

		// If cart is empty, or if book has no price or has no media, you shouldn't be here
		if(CartHelper::isEmpty() || !isset($book->price) || $book->media->isEmpty()) {
			return $this->abortByRequestMethod($request, 400, 'Book not available');
		}

		// Retrieve cart
		$cart = session('cart');
		
		// If book id found in cart and is over 1, just update quantity
		if(array_key_exists($book->id, $cart) && $cart[$book->id]['quantity'] > 1) {		
			$cart[$book->id]['quantity'] -= 1;
		} elseif(array_key_exists($book->id, $cart) && $cart[$book->id]['quantity'] <= 1) { // If book id found in cart and is 1, just delete from cart
			unset($cart[$book->id]);
		} else { // If book is not in cart, you shouldn't be here neither
			return $this->abortByRequestMethod($request, 400, 'Book not available');
		}

		// Save new cart in sesh and redirect
		session(['cart' => $cart]);
		if($request->isMethod('POST')) {
			return response()->json($bookReturnedDetails);
		} else {
			return $this->redirectIfEmpty();
		}
	}

	public function removeAll(Request $request, $id) {

		$book = Book::with('media')->findOrFail($id);

		// If cart is empty, or if book has no price or has no media, you shouldn't be here
		if(CartHelper::isEmpty() || !isset($book->price) || $book->media->isEmpty()) {
			return $this->abortByRequestMethod($request, 400, 'Book not available');
		}

		// Retrieve cart
		$cart = session('cart');
		
		// If book id found in cart, just delete it
		if(array_key_exists($book->id, $cart)) {		
			unset($cart[$book->id]);
		} else { // If book is not in cart, you shouldn't be here neither
			return $this->abortByRequestMethod($request, 400, 'Book not available');
		}

		// Save new cart in sesh and redirect
		session(['cart' => $cart]);
		return $this->redirectIfEmpty();
	}

	public function clearCart() {
		session()->forget('cart');
		return redirect(route('index'));
	}

	public function shipping(Request $request) {
		return view('index.cart.shipping');
	}

	public function checkout(Request $request) {

		// In-house shipping method
		//$data = $request->validate($this->validation);

		
		if(session()->has('cart')) {
			$cart = session('cart');
		} else {
			return redirect('cart');
		}

		$books = Book::with([
			'media' => function($q) { $q->orderBy('pivot_order', 'asc'); }
		])->findMany(array_keys($cart));
		$books->each(function($book) use($cart) {
			$book->cartQuantity = $cart[$book->id]['quantity'];
		});

		// Paypal checkout (Shipping handled by paypal)
		return view('index.cart.checkout-paypal', compact('books'));
		
		// In-house shipping method
		//return view('index.cart.checkout', compact('data', 'books'));
		//Order::create($data);
	}

	public function success() {
		session()->forget('cart');
		return view('index.cart.confirmed');
	}
}
