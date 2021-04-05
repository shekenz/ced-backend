<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Medium;
use App\Http\Controllers\MediaController;

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
		'files.*' => ['nullable', 'file', 'mimes:jpg,gif,png', 'max:512'],
		'media' => ['nullable', 'array'],
		'detach' => ['nullable', 'array'],
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

	public function create() {
		$media = Medium::all();
		return view('books.create', compact('media'));
	}

	public function store(Request $request) {

		$data = $request->validate($this->validation);

		// Array containing all media ids to attach to the new book
		$mediaIDs = array();

		// Extracting files from $data if it exists
		if(array_key_exists('files', $data)) {
			$files = $data['files'];
			unset($data['files']);
			// Uploaded files treatment
			foreach($files as $file) {
				// Create a hash name and extension
				$basename = explode('.', $file->hashName());
				// Saving file
				$filepath = $file->storeAs('uploads', $basename[0].'.'.$basename[1], 'public');
				MediaController::generateOptimized($filepath);
				// Database entry
				$medium = auth()->user()->media()->create([
					'filehash' => $basename[0],
					'extension' => $basename[1],
					'name' => $file->getClientOriginalName(),
				]);
				// Pushing new files ids for attachment
				array_push($mediaIDs, $medium->getAttribute('id'));
			}
		}

		if(array_key_exists('media', $data)) {
			$mediaIDs = array_merge($mediaIDs, $data['media']);
			unset($data['media']);
		}

		$book = auth()->user()->books()->create($data);

		if(!empty($mediaIDs)) {
			$book->media()->attach($mediaIDs);
		}

		return redirect(route('books'));
	}

	public function edit($id) {
		$media = Medium::all();
		$book = Book::with('media')->findOrFail($id);
		return view('books/edit', compact('book', 'media'));
	}

	public function update(Book $book, Request $request) {
		$data = $request->validate($this->validation);

		// Array containing all media ids to attach to the new book
		$mediaIDs = array();
		
		if(array_key_exists('files', $data)) {
			$files = $data['files'];
			unset($data['files']);
			// Uploaded files treatment
			foreach($files as $file) {
				// New filename
				$basename = explode('.', $file->hashName());
				// Saving file
				$filepath = $file->storeAs('uploads', $basename[0].'.'.$basename[1], 'public');
				MediaController::generateOptimized($filepath);
				// Database entry
				$medium = auth()->user()->media()->create([
					'filehash' => $basename[0],
					'extension' => $basename[1],
					'name' => $file->getClientOriginalName(),
				]);
				// Pushing new files ids for attachment
				array_push($mediaIDs, $medium->getAttribute('id'));
			}
		}

		if(array_key_exists('media', $data)) {
			$mediaIDs = array_merge($mediaIDs, $data['media']);
			unset($data['media']);
		}

		if(array_key_exists('detach', $data)) {
			$book->media()->detach($data['detach']);
			unset($data['detach']);
		}

		if(!empty($mediaIDs)) {
			$book->media()->attach($mediaIDs);
		}

		$book->update($data);

		return redirect(route('books'));
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
		// MUST ALSO DETACH LINKED MEDIAS
		// Can't bind a deleted model, will throw a 404
		Book::onlyTrashed()->findOrFail($id)->forceDelete();
		return redirect(route('books'));
	}

	public function deleteAll() {
		// MUST ALSO DETACH LINKED MEDIAS
		Book::onlyTrashed()->forceDelete();
		return redirect(route('books'));
	}

	public function restore($id) {
		// Can't bind a deleted model, will throw a 404
		Book::onlyTrashed()->findOrFail($id)->restore();
		return  redirect(route('books.archived'));
	}

	public function archived() {
		$books = Book::onlyTrashed()->get();
		$archived = Book::onlyTrashed()->count();
		return view('books/archived', compact('books', 'archived'));
	}
}