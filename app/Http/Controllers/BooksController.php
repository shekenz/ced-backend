<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Medium;
use App\Traits\MediaManager;

/**
 * Controller for the Books Library
 */
class BooksController extends Controller
{
	use MediaManager;

	/** @var array $validation contains the validation rules for creating or updating a book */
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
		'files.*' => ['nullable', 'file', 'mimes:jpg,gif,png'],
		'media' => ['nullable', 'array'],
		'detach' => ['nullable', 'array'],
	];

	public function __contruct() {
    }

	/** Lists all books from the library for the frontend index. Filters out books with no linked media. */
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

	/** Lists all books from the library. Index of the books library in backend. */
	public function list() {
		$books = Book::orderBy('created_at', 'DESC')->get();
		$archived = Book::onlyTrashed()->count();
        return view('books/list', compact('books', 'archived'));
	}
	
	/** Displays the book resume in backend. */
	public function display($id) {
		$book = Book::with('media')->findOrFail($id);
		return view('books.display', compact('book'));
	}

	/** Displays new book creation page. */
	public function create() {
		$media = Medium::all();
		return view('books/create', compact('media'));
	}

	/** Create a new book in the database and links it with provided media. */
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

	/** Displays the book edition page. */
	public function edit($id) {
		$media = Medium::all();
		$book = Book::with('media')->findOrFail($id);
		return view('books/edit', compact('book', 'media'));
	}

	/** Updates the book's info and re-links media if necessary. */
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

	// Lists all archived books. Index of archives in backend.
	public function archived() {
		$books = Book::onlyTrashed()->get();
		$archived = Book::onlyTrashed()->count();
		return view('books/archived', compact('books', 'archived'));
	}

	// Archives a book (SoftDelete)
	public function archive(Book $book) {
		$book->delete();
		return redirect(route('books'));
	}

	// Restore a book from archives to library.
	public function restore($id) {
		// Can't bind a deleted model, will throw a 404
		Book::onlyTrashed()->findOrFail($id)->restore();
		return  redirect(route('books.archived'));
	}

	// Permanently deletes a book from archives.
	public function delete($id) {
		// Can't bind a deleted model, will throw a 404
		$book = Book::with('media')->onlyTrashed()->findOrFail($id);
		$book->media()->detach();
		$book->forceDelete();
		return redirect(route('books.archived'));
	}

	// Permanently deletes ALL books from archives.
	public function deleteAll() {
		$books = Book::with('media')->onlyTrashed()->get();
		foreach($books as $book) {
			$book->media()->detach();
		}
		Book::with('media')->onlyTrashed()->forceDelete();
		return redirect(route('books'));
	}
}