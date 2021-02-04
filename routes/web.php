<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\PostsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Main index route
// Route::get('/', function () {
//     return view('index');
// })->name('home');
Route::view('/', 'index')->name('home');

// Dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth')->name('dashboard');

// Users (Auth in controller)
Route::get('/user/{id}', [UsersController::class, 'display'])->name('users.display');

// Posts (Auth in controller)
Route::view('/posts', 'posts.index')->name('posts.index');
Route::post('/posts', [PostsController::class, 'store'])->name('posts.store');
Route::get('/post/create', [PostsController::class, 'create'])->name('posts.create');

// Media
Route::view('/media', 'media.index')->middleware('auth')->name('media.index');
Route::get('/media/create', [MediaController::class, 'create'])->middleware('auth')->name('media.create');

// Profile
Route::view('/profile', 'profile')->middleware('auth')->name('profile');

require __DIR__.'/auth.php';
