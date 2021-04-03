<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;

class BooksController extends Controller
{

	protected $validation = [
		'title' => ['required', 'string', 'max:128'],
		'author' => ['required', 'string', 'max:64'],
		'width' => ['nullable', 'integer'],
		'height' => ['nullable', 'integer'],
		'pages' => ['nullable', 'integer'],
		'cover' => ['nullable', 'string', 'max:32'],
		'edition' => ['nullable', 'max:64'],
		'price' => ['nullable', 'numeric'],
		'description' => ['required', 'string'],
	];

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
		$data = $request->validate($this->validation);
		$id = auth()->user()->books()->create($data)->id;
		return redirect(route('books.display', $id));
	}

	public function edit(Book $book) {
		return view('books/edit', compact('book'));
	}

	public function update(Book $book, Request $request) {
		$data = $request->validate($this->validation);
		$book->update($data);
		return redirect(route('books.display', $book->id));
	}

	public function display($id) {
		$book = Book::findOrFail($id);
		return view('books.display', compact('book'));
	}

	public function delete(Book $book) {
		$book->delete();
		return redirect(route('books'));
	}
}