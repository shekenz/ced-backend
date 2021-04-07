<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Medium;
use App\Models\Book;
use App\Traits\MediaManager;

/**
 * Controller for the Media Library.
*/
class MediaController extends Controller
{
	use MediaManager;

    public function __contruct() {
        $this->middleware('auth');
    }

	/** Lists all media from the library. Index of the media library in backend. */
    public function list(){
        $media = Medium::orderBy('id', 'DESC')->get();
        return view('media/list', compact('media'));
    }

	/** Displays a single image with more info and with the renaming form. */
    public function display(Medium $medium) {
        return view('media/display', compact('medium'));
    }

	/** Displays new media creation page. */
    public function create() {
        return view('media/create');
    }

	/** 
	 * Saves uploaded files.
	 * Renames files if a specific name has been provided, otherwise it will use the original file name.
	 * If multiple files are uploaded with a specific name, they will be batch-renamed with an _index suffix.
	 * */
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
				self::storeMedia($file, [
					'name' => $data['name'].'_'.$key
				]);
			}
		}

        return redirect(route('media'));
    }

	/** Updates a single file, basically renaming it. */
	public function update(Medium $medium, Request $request) {
		$data = $request->validate([
			'name' => ['required', 'string', 'max:64'],
		]);
		$medium->update($data);
		return redirect(route('media.display', $medium));
	}

	/** Breaks link between a medium and its related book. */
	public function breakLink(Medium $medium, Book $book) {
		$medium->books()->detach($book);
		return redirect(route('books.display', $book));
	}

	/** 
	 * Permanently deletes media from the library, and deletes all its related stored files.
	 * @todo Remove all suffixed files with a foreach.
	*/
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

	/** Re-generate missing resized copies of a specific medium */
	public function rebuild(Medium $medium) {
		self::generateOptimized('uploads/'.$medium->filename);
		return redirect(route('media'));
	}

	/** Re-generate missing resized copies of a all media */
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
