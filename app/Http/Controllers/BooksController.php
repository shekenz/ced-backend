<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;

class BooksController extends Controller
{
	public function __contruct() {
        $this->middleware('auth');
    }

    public function front() {
		$books = Book::orderBy('created_at', 'DESC')->get();
        return view('books/front', compact('books'));
	}
}