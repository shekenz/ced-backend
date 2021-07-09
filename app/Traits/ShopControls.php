<?php

namespace App\Traits;

use App\Models\ShippingMethod;

trait ShopControls {

	protected function shopOn() {
		setting(['app.shop.enabled' => true]);
		setting()->save();
	}
	
	protected function shopOff() {
		setting(['app.shop.enabled' => false]);
		setting()->save();
	}
	
	/**
	 * Test if shop is not available. Returns a string sith the reason why it is not available, or false.
	 *
	 * @return {string||false}
	 */
	protected function isShopNotAvailable() {
		$hasShippingMethod = ShippingMethod::first();
		if(!$hasShippingMethod) {
			return __('flash.settings.shop.reasons.noShippingMethods');
		} elseif(!setting('app.paypal.client-id') || !setting('app.paypal.secret')) {
			return __('flash.settings.shop.reasons.noPaypalCredentials');
		} else {
			return false;
		}
	}

}