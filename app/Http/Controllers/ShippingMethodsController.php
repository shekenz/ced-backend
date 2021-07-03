<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShippingMethod;

class ShippingMethodsController extends Controller
{
	protected $validation = [
		"label" => ['required', 'string'],
		"price" => ['required', 'numeric']
	];

    public function add(Request $request) {
		$data = $request->validate($this->validation);
		ShippingMethod::create($data);
		return redirect()->route('settings');
	}
	
	public function delete(ShippingMethod $shippingMethod) {
		$shippingMethod->delete();
		return redirect()->route('settings');
	}
}
