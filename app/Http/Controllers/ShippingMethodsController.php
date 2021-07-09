<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShippingMethod;
use App\Traits\ShopControls;

class ShippingMethodsController extends Controller
{

	use ShopControls;

	protected $validation = [
		"label" => ['required', 'string', 'unique:App\Models\ShippingMethod,label'],
		"price" => ['required', 'numeric'],
		"tracking_url" => ['string', 'nullable'],
	];

    public function add(Request $request) {
		$data = $request->validate($this->validation);
		ShippingMethod::create($data);
		return redirect()->route('settings');
	}
	
	public function delete(ShippingMethod $shippingMethod) {
		$shippingMethod->delete();

		if($this->isShopNotAvailable()) {
			$this->shopOff();
		}

		return redirect()->route('settings');
	}
}
