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

	// Clean cart by removing not valid books.
	protected function cleanCart(array $validBooks) {
		$cart = session('cart');
		$sizeDiff = count($cart) - count($validBooks);
		$booksIdKeys = [];
		// Transform validBooks into an array with keys as book Id
		foreach($validBooks as $book) {
			$booksIdKeys[$book->id] = null;
		}
		session(['cart' => array_intersect_key($cart, $booksIdKeys)]);
		if($sizeDiff > 0) {
			return true;
		} else {
			return false;
		}
	}

    public function viewCart(Request $request) {
		$cart = $request->session()->get('cart', false);
		if($cart) {
			$books = [];
			foreach($cart as $id => $cartQuantity) {
				$book = Book::with('media')->find($id);
				// Control if book has a price, has at least 1 media, and is not archived
				if(isset($book->price) && $book->media->isNotEmpty()) {
					$book->cartQuantity = $cartQuantity;
					array_push($books, $book);
				}
			}
			if($this->cleanCart($books)) {
				session()->flash('flash', __('flash.cart.forceUpdate'));
				session()->flash('flash-type', 'warning');
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
			$cart[$book->id] += 1;
		} else { // If else push new book id with quantity of 1
			$cart[$book->id] = 1;
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

	public function updateCart() {
		session([
			'cart' => [
				'1' => 2,
				'2' => 4
			],
		]);
		return redirect(route('cart'));
	}

	public function clearCart() {
		session()->forget('cart');
		return redirect(route('index'));
	}
}
