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
Route::get('/dashboard/user/edit/{user}', [UsersController::class, 'edit'])->name('users.edit');
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
Route::get('/dashboard/book/create', [BooksController::class, 'create'])->middleware('auth')->name('books.create');
Route::post('/dashboard/books', [BooksController::class, 'store'])->name('books.store');
Route::get('/dashboard/book/edit/{book}', [BooksController::class, 'edit'])->name('books.edit');
Route::patch('/dashboard/book/{book}', [BooksController::class, 'update'])->name('books.update');
Route::get('/dashboard/book/{id}', [BooksController::class, 'display'])->name('books.display');
Route::get('/dashboard/book/archive/{book}', [BooksController::class, 'archive'])->name('books.archive');
Route::post('/dashboard/book/delete/{id}', [BooksController::class, 'delete'])->name('books.delete');
Route::post('/dashboard/books/archived/delete', [BooksController::class, 'deleteAll'])->name('books.deleteAll');
Route::get('/dashboard/book/restore/{id}', [BooksController::class, 'restore'])->name('books.restore');
Route::get('/dashboard/books/archived', [BooksController::class, 'archived'])->name('books.archived');

Route::get('/dashboard/attach', function() {
	$book = \App\Models\Book::with('media')->first();
	$medium = \App\Models\Medium::with('books')->first();
	//$book->media()->attach('2');
	//$medium->books()->attach('2');
	//\App\Models\Book::findOrFail('18')->media()->attach('1');
	dump($medium);
	dd(\App\Models\Book::with('media')->findOrFail('18'));
})->middleware('auth');

// Media
Route::get('/dashboard/media', [MediaController::class, 'index'])->name('media');
Route::post('/dashboard/media', [MediaController::class, 'store'])->name('media.store');
Route::get('/dashboard/media/create', [MediaController::class, 'create'])->name('media.create');
Route::get('/dashboard/media/{medium}', [MediaController::class, 'display'])->name('media.display');
Route::get('/dashboard/media/{medium}/break/{book}', [MediaController::class, 'breakLink'])->name('media.break');

require __DIR__.'/auth.php';
