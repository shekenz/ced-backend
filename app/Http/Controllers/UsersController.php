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

    public function display($id) {
        $user = User::findOrFail($id);
       return view('profile', [
           'user' => $user,
       ]);
    }
}
