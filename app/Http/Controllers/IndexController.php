<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Mail\Markdown;

class IndexController extends Controller
{
    public function about() {

		$abouts = [
			Markdown::parse((Storage::disk('raw')->exists('about_0.txt')) ? nl2br(Storage::disk('raw')->get('about_0.txt')) : ''),
			Markdown::parse((Storage::disk('raw')->exists('about_1.txt')) ? nl2br(Storage::disk('raw')->get('about_1.txt')) : ''),
		];

		return view('index.about', compact('abouts'));

	}
}
