<?php

namespace App\Http\Controllers;

use App\Mail\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MessagesController extends Controller
{
    public function list() {

	}

	public function forward(Request $request) {
		$data = $request->validate([
			'email' => ['max:256', 'required', 'email'],
			'subject' => ['max:256', 'required'],
			'message' => ['required'],
		]);
		//dd($data);
		Mail::to('aureltrotebas@icloud.com')->send(New ContactMessage($data));
	}
}
