<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\MediaController;
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

Route::get('/user/{user}', [UsersController::class, 'display'])->name('users.display');
Route::get('/user/{user}/edit', [UsersController::class, 'edit'])->name('users.edit');

// Posts (Auth in controller)
Route::view('/posts', 'posts/index')->name('posts.index');
Route::post('/posts', [PostsController::class, 'store'])->name('posts.store');
Route::get('/post/create', [PostsController::class, 'create'])->name('posts.create');
Route::get('/post/{id}', [PostsController::class, 'display'])->name('posts.display');

// Media
Route::get('/media', [MediaController::class, 'index'])->name('media.index');
Route::post('/media', [MediaController::class, 'store'])->name('media.store');
Route::get('/media/create', [MediaController::class, 'create'])->name('media.create');
Route::get('/media/{medium}', [MediaController::class, 'display'])->name('media.display');

require __DIR__.'/auth.php';
