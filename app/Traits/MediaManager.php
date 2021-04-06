<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Illuminate\Http\UploadedFile;
trait MediaManager {

	public static function storeMedia(UploadedFile $file, string $name = null) {

		// Generate default name (not filename)
		if(!$name) {
			// Removing everything after last dot, hence the extension
			$name = implode('.', explode('.', $file->getClientOriginalName(), -1));
		}

		// Get filename, hashname and extension
		// filename = hashname.extension
		$filename = $file->hashName();
		$basename = explode('.', $filename);

		// Store file
		$filepath = $file->storeAs('uploads', $basename[0].'.'.$basename[1], 'public');
		
		// Generate optimized copies
		self::generateOptimized($filepath);

		// Save into database
		$medium = auth()->user()->media()->create([
			'filehash' => $basename[0],
			'extension' => $basename[1],
			'name' => $name,
		]);

		return $medium->getAttribute('id');
	}

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
}