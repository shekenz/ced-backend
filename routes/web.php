<?php

use App\Http\Controllers\BooksController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\FrontController;

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
//Route::get('/', [FrontController::class, 'index'])->name('index');

Route::get('/', [BooksController::class, 'front'])->name('index');
Route::view('/cart', 'index/cart', [
	'subTotal' => '240',
	'artist' => 'Name',
	'title' => 'Title',
	'quantity' => '1',
])->name('cart');
Route::view('/about', 'index/about')->name('about');
Route::view('/contact', 'index/contact')->name('contact');


// Dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth')->name('dashboard');

// Users (Auth in controller)
Route::get('/dashboard/users', [UsersController::class, 'index'])->name('users');
Route::get('/dashboard/user/{user}', [UsersController::class, 'display'])->name('users.display');
Route::get('/dashboard/user/{user}/edit', [UsersController::class, 'edit'])->name('users.edit');
Route::patch('/dashboard/user/{user}', [UsersController::class, 'update'])->name('users.update');
Route::post('/dashboard/user/delete/{user}', [UsersController::class, 'delete'])->name('users.delete');

// Posts (Auth in controller)
Route::get('/dashboard/posts', [PostsController::class, 'index'])->name('posts');
Route::post('/dashboard/posts', [PostsController::class, 'store'])->name('posts.store');
Route::get('/dashboard/post/create', [PostsController::class, 'create'])->name('posts.create');
Route::get('/dashboard/post/{id}', [PostsController::class, 'display'])->name('posts.display');
Route::get('/dashboard/post/{post}/edit', [PostsController::class, 'edit'])->name('posts.edit');
Route::patch('/dashboard/post/{post}', [PostsController::class, 'update'])->name('posts.update');

// Boks (Auth in controller)
Route::get('/dashboard/books', [BooksController::class, 'index'])->name('books');

// Media
Route::get('/dashboard/media', [MediaController::class, 'index'])->name('media');
Route::post('/dashboard/media', [MediaController::class, 'store'])->name('media.store');
Route::get('/dashboard/media/create', [MediaController::class, 'create'])->name('media.create');
Route::get('/media/{medium}', [MediaController::class, 'display'])->name('media.display');

require __DIR__.'/auth.php';
