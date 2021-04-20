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

		return view('settings.main');
	}
}
