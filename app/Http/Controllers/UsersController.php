<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;

// Models
use App\Models\User;

/**
 * Controller for Users
 */

class UsersController extends Controller
{
    public function __contruct() {
        $this->middleware('auth');
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
}
