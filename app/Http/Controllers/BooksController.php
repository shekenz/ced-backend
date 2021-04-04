<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Medium;

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
		$books = Book::with('media')->orderBy('created_at', 'DESC')->get();
        return view('books/front', compact('books'));
	}

	public function index() {
		$books = Book::orderBy('created_at', 'DESC')->get();
		$archived = Book::onlyTrashed()->count();
        return view('books/index', compact('books', 'archived'));
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
		$book = Book::with('media')->findOrFail($id);
		return view('books.display', compact('book'));
	}

	public function archive(Book $book) {
		$book->delete();
		return redirect(route('books'));
	}

	public function delete($id) {
		// Can't bind a deleted model, will throw a 404
		Book::onlyTrashed()->findOrFail($id)->forceDelete();
		return redirect(route('books'));
	}

	public function deleteAll() {
		Book::onlyTrashed()->forceDelete();
		return redirect(route('books'));
	}

	public function restore($id) {
		// Can't bind a deleted model, will throw a 404
		Book::onlyTrashed()->findOrFail($id)->restore();
		return  redirect(route('books'));
	}

	public function archived() {
		$books = Book::onlyTrashed()->get();
		$archived = Book::onlyTrashed()->count();
		return view('books/archived', compact('books', 'archived'));
	}
}