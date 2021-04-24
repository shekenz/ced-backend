<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
		if(config('app.allow_register')) {
        	return view('auth.register');
		} else {
			return redirect(route('login'));
		}
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:64|unique:users',
            'lastname' => 'required|string|max:64',
            'firstname' => 'required|string|max:64',
            'email' => 'required|string|email|max:256|unique:users',
            'password' => 'required|string|confirmed|min:8',
            'birthdate' => 'present'
        ]);

        Auth::login($user = User::create([
            'username' => $request->username,
            'lastname' => $request->lastname,
            'firstname' => $request->firstname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'birthdate' => $request->birthdate,
        ]));

        event(new Registered($user));

        return redirect(RouteServiceProvider::HOME);
    }
}
