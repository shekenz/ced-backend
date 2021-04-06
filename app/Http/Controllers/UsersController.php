<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;

// Models
use App\Models\User;



class UsersController extends Controller
{
    public function __contruct() {
        $this->middleware('auth');
    }
    public function list() {
        $users = User::all();
        return view('users/list')->with('users', $users);
    }
    public function display(User $user) {
       return view('users/display', compact('user'));
    }

    public function edit(User $user) {
        return view('users/edit', compact('user')); 
    }

    public function update(User $user, UserRequest $request) {
        // Validation is automated in the UserRequest
        $data = $request->validated();
        !$data['password'] ?: $data['password'] = Hash::make($data['password']);
        $user->update(array_filter($data)); // Remove all null or empty values (falses) from the validated data

        return redirect(route('users.display', ['user' => $user->id]));
    }
}
