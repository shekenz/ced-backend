<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use App\Mail\UserInvite;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Models\InviteToken;
use Illuminate\Support\Str;


// Models
use App\Models\User;

/**
 * Controller for Users
 */

class UsersController extends Controller
{
    public function __contruct() {
    }

	/** Lists all users. Index of users in backend. */
    public function list() {
        $users = User::all();
        return view('users/list')->with('users', $users);
    }

	/** 
	 * Displays a single users with all info. 
	 * @todo Filter out sensitive info if user is not connected.
	*/
    public function display(User $user) {
       return view('users/display', compact('user'));
    }

	/** Displays user's edit page. */
    public function edit(User $user) {
        return view('users/edit', compact('user')); 
    }

	/** Updates user's info. */
    public function update(User $user, UserRequest $request) {
        // Validation is automated in the UserRequest
        $data = $request->validated();
        !$data['password'] ?: $data['password'] = Hash::make($data['password']);
        $user->update(array_filter($data)); // Remove all null or empty values (falses) from the validated data

        return redirect(route('users.display', ['user' => $user->id]));
    }

	/** Invite a new user to register */
	public function invitation() {
		return view('users.invitation');
	}

	public static function inviteByMail(string $email) {
		$token = Str::random(40);
		InviteToken::create([
			'token' => $token,
		]);
		Mail::to($email)->send(new UserInvite($token));
	}

	public function invite(Request $request) {
		$data = $request->validate([
			'email' => ['max:256', 'email', 'required'],
		]);

		Self::inviteByMail($data['email']);
		
		return redirect()->route('users')->with([
			'flash' => __('flash.user.invited', ['email' => $data['email']]),
			'flash-type' => 'success'
		]);
	}
}
