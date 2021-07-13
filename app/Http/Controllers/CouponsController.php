<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Coupon;
use Carbon\Carbon;

class CouponsController extends Controller
{

	public $validation = [
		'label' => [
			'unique:coupons,label',
			'max:8',
			'required',
		],
		'value' => [
			'numeric',
			'required',
		],
		'type' => [
			'boolean',
			'required',
		],
		'quantity' => [
			'numeric',
		],
		'starts_at' => [
			'date',
			'required',
		],
		'expires_at' => [
			'date',
			'required',
			'after:starts_at',
		]
	];

    public function add(Request $request) {
		$data = $request->validate($this->validation);
		Coupon::create($data);

		return back();
	}
	
	/**
	 * get
	 *
	 * @param  Request $request
	 * @param  str $couponLabel
	 */
	public function get(Request $request, string $couponLabel) {
		if($request->wantsJson()) {
			$coupon = Coupon::where('label', $couponLabel)->first();
			if($coupon && Carbon::now()->between($coupon->starts_at, $coupon->expires_at)) {
				return response()->json($coupon);
			} else {
				return response()->json();
			}
		} else {
			return abort(404);
		}
	}
}
