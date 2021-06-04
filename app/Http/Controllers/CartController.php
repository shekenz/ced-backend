<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Http\Helpers\CartHelper;

class CartController extends Controller
{

	//TODO helper to check if book has a price and a picture, or throw a 404 if not (Same behavior as when we try to add a archived book)

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
			$books = [];
			foreach($cart as $id => $cartQuantity) {
				$book = Book::with('media')->find($id);
				// Control if book has a price
				if(isset($book->price)) {
					$book->cartQuantity = $cartQuantity;
					array_push($books, $book);
				} else {
					$this->removeAll($book);
				}
			}

			return view('index.cart', compact('books'));
		} else {
			return view('index.cart');
		}
		
	}

	public function add(Book $book) {

		// If book has no price, you shouldn't be here
		if(!isset($book->price)) {
			return redirect(route('index'));
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

	public function remove(Book $book) {

		// If cart is empty, or if book has no price, you shouldn't be here
		if(CartHelper::isEmpty()) {
			return redirect(route('index'));
		}

		// Retrieve cart
		$cart = session('cart');
		
		// If book id found in cart and is over 1, just update quantity
		if(array_key_exists($book->id, $cart) && $cart[$book->id] > 1) {		
			$cart[$book->id] -= 1;
		} elseif(array_key_exists($book->id, $cart) && $cart[$book->id] <= 1) { // If book id found in cart and is 1, just delete from cart
			unset($cart[$book->id]);
		} else { // If book is not in cart, you shouldn't be here neither
			return redirect(route('index'));
		}

		// Save new cart in sesh and redirect
		session(['cart' => $cart]);
		return $this->redirectIfEmpty();
	}

	public function removeAll(Book $book) {

		// If cart is empty, or if book has no price, you shouldn't be here
		if(CartHelper::isEmpty()) {
			return redirect(route('index'));
		}

		// Retrieve cart
		$cart = session('cart');
		
		// If book id found in cart, just delete it
		if(array_key_exists($book->id, $cart)) {		
			unset($cart[$book->id]);
		} else { // If book is not in cart, you shouldn't be here neither
			return redirect(route('index'));
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
