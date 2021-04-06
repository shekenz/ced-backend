<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Medium;
use App\Traits\MediaManager;

class BooksController extends Controller
{
	use MediaManager;

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
		'files.*' => ['nullable', 'file', 'mimes:jpg,gif,png', 'max:512'],
		'media' => ['nullable', 'array'],
		'detach' => ['nullable', 'array'],
	];

	public function __contruct() {
        $this->middleware('auth');
    }

    public function index() {
		// We need to filter out the books without linked images because gilde.js hangs if it have no child elements.
		// We also need a clean ordered index to link each glides to its corresponding counter.
		$books = Book::with('media')
			->orderBy('created_at', 'DESC')
			->get()
			->filter(function($value) {
				return $value->media->isNotEmpty();
			})
			->values();
        return view('books/index', compact('books'));
	}

	public function list() {
		$books = Book::orderBy('created_at', 'DESC')->get();
		$archived = Book::onlyTrashed()->count();
        return view('books/list', compact('books', 'archived'));
	}

	public function create() {
		$media = Medium::all();
		return view('books/create', compact('media'));
	}

	public function store(Request $request) {
		$data = $request->validate($this->validation);
		$mediaIDs = array(); // Array containing all media ids to attach to the new book

		// Storing all uploaded images
		if(array_key_exists('files', $data)) {
			foreach($data['files'] as $file) {
				// Pushing new files ids for attachment
				array_push($mediaIDs, self::storeMedia($file));
			}
		}

		// Merging files uploaded and files from library together for attachment
		if(array_key_exists('media', $data)) {
			$mediaIDs = array_merge($mediaIDs, $data['media']);
		}

		// Attach
		if(!empty($mediaIDs)) {
			$book->media()->attach($mediaIDs);
		}

		// Saving book
		$book = auth()->user()->books()->create($data);
		return redirect(route('books'));
	}

	public function edit($id) {
		$media = Medium::all();
		$book = Book::with('media')->findOrFail($id);
		return view('books/edit', compact('book', 'media'));
	}

	public function update(Book $book, Request $request) {
		$data = $request->validate($this->validation);
		$mediaIDs = array(); // Array containing all media ids to attach to the new book

		// Storing all uploaded images
		if(array_key_exists('files', $data)) {
			foreach($data['files'] as $file) {
				// Pushing new files ids for attachment
				array_push($mediaIDs, self::storeMedia($file));
			}
		}

		// Merging uploaded and from library IDs to attach
		if(array_key_exists('media', $data)) {
			$mediaIDs = array_merge($mediaIDs, $data['media']);
		}

		// Attaching
		if(!empty($mediaIDs)) {
			$book->media()->attach($mediaIDs);
		}

		// Detaching
		if(array_key_exists('detach', $data)) {
			$book->media()->detach($data['detach']);
		}

		// Updating book
		$book->update($data);
		return redirect(route('books'));
	}

	public function display($id) {
		$book = Book::with('media')->findOrFail($id);
		return view('books.display', compact('book'));
	}


	public function archived() {
		$books = Book::onlyTrashed()->get();
		$archived = Book::onlyTrashed()->count();
		return view('books/archived', compact('books', 'archived'));
	}

	public function archive(Book $book) {
		$book->delete();
		return redirect(route('books'));
	}

	public function restore($id) {
		// Can't bind a deleted model, will throw a 404
		Book::onlyTrashed()->findOrFail($id)->restore();
		return  redirect(route('books.archived'));
	}

	public function delete($id) {
		// Can't bind a deleted model, will throw a 404
		$book = Book::with('media')->onlyTrashed()->findOrFail($id);
		$book->media()->detach();
		$book->forceDelete();
		return redirect(route('books.archived'));
	}

	public function deleteAll() {
		$books = Book::with('media')->onlyTrashed()->get();
		foreach($books as $book) {
			$book->media()->detach();
		}
		Book::with('media')->onlyTrashed()->forceDelete();
		return redirect(route('books'));
	}
}