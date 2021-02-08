<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// Models
use App\Models\User;

class UsersController extends Controller
{
    public function __contruct() {
        $this->middleware('auth');
    }
    public function index() {
        $users = User::all();
        return view('users/index')->with('users', $users);
    }
    public function display(User $user) {
       return view('users/display', compact('user'));
    }

    public function edit(User $user) {
        return view('users/display', compact('user')); 
    }
}
