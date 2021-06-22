<?php

namespace App\Http\Helpers;

class CartHelper {

	private static $count = 0;

	public static function count() {
		if(!self::isEmpty()) {
			self::$count = 0;
			foreach(session('cart') as $article) {
				self::$count += intval($article['quantity']);
			}
			return self::$count;
		} else {
			return false;
		}
	}

	public static function isEmpty() {
		return (!session()->has('cart') || ( count(session('cart')) == 0) );
	}

}