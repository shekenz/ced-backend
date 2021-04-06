<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Medium;
use App\Models\Book;
use Illuminate\Support\Facades\Storage;
use App\Traits\MediaManager;

class MediaController extends Controller
{
	use MediaManager;

    public function __contruct() {
        $this->middleware('auth');
    }
    //
    public function list(){
        $media = Medium::orderBy('id', 'DESC')->get();
        return view('media/list', compact('media'));
    }

    public function create() {
        return view('media/create');
    }

    public function store() {
		// Fields validation
        $data = request()->validate([
            'name' => ['max:64'],
			'files' => ['required', 'array'],
            'files.*' => ['file', 'mimes:jpg,gif,png', 'max:512'],
        ]);

		if(count($data['files']) <= 1) {
			self::storeMedia($data['files'][0], $data['name']);
		} else {
			foreach($data['files'] as $key => $file) {
				self::storeMedia($file, $data['name'].'_'.$key);
			}
		}

        return redirect(route('media'));
    }

    public function display(Medium $medium) {
        return view('media/display', compact('medium'));
    }

	public function update(Medium $medium, Request $request) {
		$data = $request->validate([
			'name' => ['required', 'string', 'max:64'],
		]);
		$medium->update($data);
		return redirect(route('media.display', $medium));
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
		Storage::disk('public')->delete('uploads/'.$medium->thumb);
		Storage::disk('public')->delete('uploads/'.$medium->thumb2x);
		Storage::disk('public')->delete('uploads/'.$medium->hd);
		Storage::disk('public')->delete('uploads/'.$medium->lg);
		Storage::disk('public')->delete('uploads/'.$medium->md);
		Storage::disk('public')->delete('uploads/'.$medium->sm);
		$medium->delete();

		return redirect(route('media'));
	}

	public function rebuild(Medium $medium) {
		self::generateOptimized('uploads/'.$medium->filename);
		return redirect(route('media'));
	}

	public function rebuildAll() {
		$files = Storage::disk('public')->files('uploads/');
		
		// Filtering out other files than original
		$originals = array_filter($files, function($item) {
			return preg_match('/^uploads\/([A-Za-z0-9]{40})\.(jpg|gif|jpeg|png)$/', $item);
		});

		foreach($originals as $path) {
			self::generateOptimized($path);
		}

		return redirect(route('media'));
	}
}
