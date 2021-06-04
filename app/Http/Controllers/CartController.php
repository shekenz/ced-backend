<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Http\Helpers\CartHelper;

class CartController extends Controller
{

	protected function redirectIfEmpty() {
		if(CartHelper::isEmpty()) {
			return redirect(route('index'));
		} else {
			return back();
		}
	}

    public function viewCart(Request $request) {
		$cart = $request->session()->get('cart', false);
		if($cart) {

			// Find all books from cart without archived books (In 1 call)
			$books = Book::with('media')->findMany(array_keys($cart));

			// Filter out if books has no price or no media
			$books = $books->filter(function($book) {
				return ($book->media->isNotEmpty() && isset($book->price));
			});

			// remap $books collection with books id as key
			$books = $books->keyBy('id');

			// Update cart according to filtered books array
			$articleUpdated = (count($cart) - $books->count() > 0);
			$cart = array_intersect_key($cart, $books->toArray());

			// Check stock limits
			$quantityUpdated = false;
			array_walk($cart, function(&$cartQuantity, $id) use ($books, &$quantityUpdated) {
				$stock = intval($books[$id]->quantity);
				if($cartQuantity > $stock) {
					$cartQuantity = $stock;
					$quantityUpdated = true;
				}
			});

			// Updates $books cartQuantity
			$books->each(function($book, $id) use ($cart) {
				$book->cartQuantity = $cart[$id];
			});

			// Update session cart
			session(['cart' => $cart]);

			// Redirect with flash if needed
			if($articleUpdated || $quantityUpdated) {
				session()->now('flash', __('flash.cart.stockUpdated'));
				session()->now('flash-type', 'warning');
				return view('index.cart', compact('books'));
			} else {
				return view('index.cart', compact('books'));
			}

		} else {
			return view('index.cart');
		}
		
	}

	public function add($id) {

		$book = Book::with('media')->findOrFail($id);

		// If book has no price or has no media, you shouldn't be here
		if(!isset($book->price) || $book->media->isEmpty()) {
			abort(404);
		}

		// If cart is empty, create new cart array
		if(CartHelper::isEmpty()) {
			$cart = [];
		} else { // or retrieve existing cart
			$cart = session('cart');
		}
		
		// If book id found in cart, just update quantity
		if(array_key_exists($book->id, $cart)) {
			if($cart[$book->id] < $book->quantity) { // Check for stock
				$cart[$book->id] += 1;
			} else {
				return back()->with([
					'flash' => __('flash.cart.stockLimit'),
					'flash-type' => 'warning',
				]);
			}
		} else { // Else push new book id with quantity of 1
			if($book->quantity > 0) { // Check for stock
				$cart[$book->id] = 1;
			} else {
				return back()->with([
					'flash' => __('flash.cart.stockLimit'),
					'flash-type' => 'warning',
				]);
			}
		}

		// Save new cart in sesh and redirect
		session(['cart' => $cart]);
		return back();
	}

	public function remove($id) {

		$book = Book::with('media')->findOrFail($id);

		// If cart is empty, or if book has no price or has no media, you shouldn't be here
		if(CartHelper::isEmpty() || !isset($book->price) || $book->media->isEmpty()) {
			abort(404);
		}

		// Retrieve cart
		$cart = session('cart');
		
		// If book id found in cart and is over 1, just update quantity
		if(array_key_exists($book->id, $cart) && $cart[$book->id] > 1) {		
			$cart[$book->id] -= 1;
		} elseif(array_key_exists($book->id, $cart) && $cart[$book->id] <= 1) { // If book id found in cart and is 1, just delete from cart
			unset($cart[$book->id]);
		} else { // If book is not in cart, you shouldn't be here neither
			abort(404);
		}

		// Save new cart in sesh and redirect
		session(['cart' => $cart]);
		return $this->redirectIfEmpty();
	}

	public function removeAll($id) {

		$book = Book::with('media')->findOrFail($id);

		// If cart is empty, or if book has no price or has no media, you shouldn't be here
		if(CartHelper::isEmpty() || !isset($book->price) || $book->media->isEmpty()) {
			abort(404);
		}

		// Retrieve cart
		$cart = session('cart');
		
		// If book id found in cart, just delete it
		if(array_key_exists($book->id, $cart)) {		
			unset($cart[$book->id]);
		} else { // If book is not in cart, you shouldn't be here neither
			abort(404);
		}

		// Save new cart in sesh and redirect
		session(['cart' => $cart]);
		return $this->redirectIfEmpty();
	}

	public function populateCart() {
		session([
			'cart' => [
				'1' => 100,
				'2' => 100,
				'3' => 100,
				'4' => 100,
				'5' => 100,
				'6' => 100,
				'7' => 100,
				'8' => 100,
				'9' => 100,
				'10' => 100,
			],
		]);
		return redirect(route('cart'));
	}

	public function clearCart() {
		session()->forget('cart');
		return redirect(route('index'));
	}
}
