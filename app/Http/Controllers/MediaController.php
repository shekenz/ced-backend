<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Medium;
use App\Models\Book;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    public function __contruct() {
        $this->middleware('auth');
    }
    //
    public function index(){
        $media = Medium::orderBy('created_at', 'DESC')->get();
        return view('media/index', compact('media'));
    }

    public function create() {
        return view('media/create');
    }

    public function store() {
        $data = request()->validate([
            'name' => ['max:64'],
            'file' => ['required', 'file', 'mimes:jpg,gif,png', 'max:512'],
        ]);
        
        // if name is empty, use original filename;
        if(!$data['name']) {
            $data['name'] = $data['file']->getClientOriginalName();
        }

        $data['filename'] = request('file')->hashName();
        request('file')->store('uploads', 'public');

// @ts-ignore
        auth()->user()->media()->create($data);

        return redirect(route('media'));
    }

    public function display(Medium $medium) {
        return view('media/display', compact('medium'));
    }

	public function breakLink(Medium $medium, Book $book) {
		$medium->books()->detach($book);
		return redirect(route('books.display', $book));
	}

	public function delete($id) {
		$medium = Medium::with('books')->findOrFail($id);
		foreach($medium->books as $book) {
			$medium->books()->detach($book);
		}
		Storage::disk('public')->delete('uploads/'.$medium->filename);
		$medium->delete();

		return redirect(route('media'));
	}
}
