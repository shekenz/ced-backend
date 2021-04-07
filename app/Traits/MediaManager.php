<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Illuminate\Http\UploadedFile;

/**
 * Helper for processing media uploads.
 */
trait MediaManager {

	/**
	 * Save uploaded file to disk and in media library. File is stored with an hashed name.
	 * @param Illuminate\Http\UploadedFile $file File to save.
	 * @param array $options Options for storing the file :
	 * @param string $options['dir'] The sub directory in ressources/storage where the file is stored. Optional, default to uploads/.
	 * @param string $options['name'] The new name of the file. Optional, default to original file name without the extension.
	 * @return string The medium id that has been saved.
	 */
	public static function storeMedia(UploadedFile $file, array $options = []) {

		// Set default name (not filename) if not provided
		if(!array_key_exists('name', $options)) {
			// Removing everything after last dot, hence the extension
			$options['name'] = implode('.', explode('.', $file->getClientOriginalName(), -1));
		}

		// Set default directory if not provided
		if(!array_key_exists('dir', $options)) {
			$options['dir'] = 'uploads';
		}

		// Get filename, hashname and extension
		// filename = hashname.extension
		$filename = $file->hashName();
		$basename = explode('.', $filename);

		// Store file
		$filepath = $file->storeAs($options['dir'], $basename[0].'.'.$basename[1], 'public');
		
		// Generate optimized copies
		self::generateOptimized($filepath);

		// Save into database
		$medium = auth()->user()->media()->create([
			'filehash' => $basename[0],
			'extension' => $basename[1],
			'name' => $options['name'],
		]);

		return $medium->getAttribute('id');
	}

	/**
	 * Generates resized copies of stored image and rename them with an appropriate suffix.
	 * @param string $filePath The sub-path in ressources/storage of the original file.
	 * @todo Generation rules should be defined in a configuration and generated according to defined options.
	 */
	public static function generateOptimized(string $filePath) {

		$fileInfo = pathinfo($filePath);
		$file = Storage::disk('public')->get($filePath);
	
		// Image modification
		$imgManager = new ImageManager();

		foreach(config('optimage') as $key => $item) {
			if (!Storage::disk('public')->exists('uploads/'.$fileInfo['filename'].'_'.$key.'.'.$fileInfo['extension'])) {
				$img = $imgManager->make($file)->fit($item['width'], $item['height'])->encode($fileInfo['extension'], $item['quality']);
				Storage::disk('public')->put('uploads/'.$fileInfo['filename'].'_'.$key.'.'.$fileInfo['extension'], (string) $img);
			}
		}
	}
}