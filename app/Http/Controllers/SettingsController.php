<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    public function update(Request $request) {
		$data = $request->validate([
			'paypal-client-id' => [
				'string',
				'nullable',
			],
			'paypal-secret' => [
				'string',
				'nullable',
			],
			'paypal-sandbox' => 'nullable',
			'shipping-allowed-countries' => [
				'regex:/^([A-z]{2},+)*([A-z]{2},*)?$/',
				'nullable',
			],
			'about' => 'array',
			'about.*' => [
				'string',
				'nullable',
			],
		]);

		// String to upper to array
		$allowedCountries = explode(',', strtoupper($data['shipping-allowed-countries']));
		// Filter out empty items
		$allowedCountries = array_unique(array_filter($allowedCountries));
		// Filter out non-existant countries
		$allowedCountries = array_filter($allowedCountries, function($value) {
			return array_key_exists(strtoupper($value), config('countries'));
		});
		// Sort by country code without case sensitivity
		natcasesort($allowedCountries);
		// Convert to regular array
		$allowedCountries = array_values($allowedCountries);

		setting(['app.shipping.allowed-countries' => $allowedCountries ]);
		setting(['app.paypal.client-id' => $data['paypal-client-id']]);
		setting(['app.paypal.secret' => $data['paypal-secret']]);
		setting(['app.paypal.sandbox' => isset($data['paypal-sandbox']) ]);
		setting()->save();
		
		foreach($data['about'] as $key => $item) {
			if($item) {
				Storage::disk('raw')->put('about_'.$key.'.txt', e($item));
			}
		}

		return redirect()->route('settings')->with([
			'flash' => __('flash.settings.updated'),
			'flash-type' => 'success'
		]);
	}

	public function publish() {
		if(setting('app.published')) {
			setting(['app.published' => false]);
			setting()->save();
			return back()->with([
				'flash' => __('flash.settings.unpublished'),
				'flash-type' => 'warning'
			]);
		} else {
			setting(['app.published' => true]);
			setting()->save();
			return back()->with([
				'flash' => __('flash.settings.published'),
				'flash-type' => 'success'
			]);
		}
	}
}
