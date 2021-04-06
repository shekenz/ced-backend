<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Medium;
use App\Models\Book;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;

class MediaController extends Controller
{
	public static function generateOptimized(string $filePath) {

		$fileInfo = pathinfo($filePath);
		$file = Storage::disk('public')->get($filePath);
	
		// Image modification
		$imgManager = new ImageManager();

		// Thumb
		if (!Storage::disk('public')->exists('uploads/'.$fileInfo['filename'].'_thumb.'.$fileInfo['extension'])) {
			$img_thumb = $imgManager->make($file)->fit(100, 100)->encode($fileInfo['extension'], 50);
			Storage::disk('public')->put('uploads/'.$fileInfo['filename'].'_thumb.'.$fileInfo['extension'], (string) $img_thumb);
		}
		
		if (!Storage::disk('public')->exists('uploads/'.$fileInfo['filename'].'_thumb@2x.'.$fileInfo['extension'])) {
			$img_thumb_2x = $imgManager->make($file)->fit(200, 200)->encode($fileInfo['extension'], 50);
			Storage::disk('public')->put('uploads/'.$fileInfo['filename'].'_thumb@2x.'.$fileInfo['extension'], (string) $img_thumb_2x);
		}
	}

    public function __contruct() {
        $this->middleware('auth');
    }
    //
    public function list(){
        $media = Medium::orderBy('created_at', 'DESC')->get();
        return view('media/list', compact('media'));
    }

    public function create() {
        return view('media/create');
    }

    public function store() {

		// Fields validation
        $data = request()->validate([
            'name' => ['max:64'],
            'file' => ['required', 'file', 'mimes:jpg,gif,png', 'max:512'],
        ]);
        
        // If name is empty, use original filename;
        if(!$data['name']) {
            $data['name'] = $data['file']->getClientOriginalName();
        }

		// Create a hash name and extension
        $basename = explode('.', request('file')->hashName());
		$data['filehash'] = $basename[0];
		$data['extension'] = $basename[1];
		
		// Store in public/storage (public disk)
        $filePath = request('file')->store('uploads', 'public');
		
		// Genrating optimized copies and thumbnails
		self::generateOptimized($filePath);

		// Database entry
        auth()->user()->media()->create($data);

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
