<?php

namespace App\Http\Helpers;

class CartHelper {

	public static function count() {
		$cart = session()->get('cart', []);
		return array_reduce($cart, function($accumulation, $article) {
			return $accumulation + $article['quantity'];
		});
	}

}