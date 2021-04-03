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

	public function index() {
		$books = Book::orderBy('created_at', 'DESC')->get();
        return view('books/index', compact('books'));
	}

	public function store(Request $request) {

		$data = $request->validate([
			'title' => ['required', 'string', 'max:128'],
			'author' => ['required', 'string', 'max:64'],
			'width' => ['nullable', 'integer'],
			'height' => ['nullable', 'integer'],
			'pages' => ['nullable', 'integer'],
			'cover' => ['nullable', 'string', 'max:32'],
			'edition' => ['nullable', 'max:64'],
			'price' => ['nullable', 'numeric'],
			'description' => ['required', 'string'],
		]);

		auth()->user()->books()->create($data);

		return redirect('/dashboard/books');

	}
}