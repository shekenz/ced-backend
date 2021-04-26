<?php

namespace App\Http\Controllers;

use App\Mail\ContactMessage;
use App\Models\User;
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
		
		$users = User::where('role', 'admin')->orWhere('role', 'postmaster')->get();
		foreach($users as $user) {
			Mail::to($user->email)->send(New ContactMessage($data));
		}
	}
}
