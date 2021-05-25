<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    public function update(Request $request) {
		$data = $request->validate([
			'about' => 'array',
			'about.*' => [
				'string',
				'nullable',
			],
		]);
		
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
