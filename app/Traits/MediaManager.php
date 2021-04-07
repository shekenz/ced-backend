<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Intervention\Image\ImageManager;
use App\Models\Medium;


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
	 */
	// TODO make the optimage manager in his own class
	public static function generateOptimized(string $filePath) {

		$fileInfo = pathinfo($filePath);
		$file = Storage::disk('public')->get($filePath);
	
		// Image modification
		$imgManager = new ImageManager();

		// TODO optimage.familly in optimage config for generating optimized file in different controllers. generateOptimized needs a new param.
		foreach(config('optimage') as $key => $item) {
			// TODO Needs to check for original file size before forcing an generation that could have a higher resolution than the original itself.
			if (!Storage::disk('public')->exists('uploads/'.$fileInfo['filename'].'_'.$key.'.'.$fileInfo['extension'])) {
				$img = $imgManager->make($file)->fit($item['width'], $item['height'])->encode($fileInfo['extension'], $item['quality']);
				Storage::disk('public')->put('uploads/'.$fileInfo['filename'].'_'.$key.'.'.$fileInfo['extension'], (string) $img);
			}
		}
	}

	/** Re-generate missing resized copies of a specific medium */
	public function rebuild(Medium $medium) {
		self::generateOptimized('uploads/'.$medium->filename);
		return redirect(route('media'));
	}

	/** Re-generate missing resized copies of a all media if they are absent */
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

	/** Remove all optimized copies for a medium */
	public static function clean(Medium $medium) {
		Storage::disk('public')->delete('uploads/'.$medium->filename);
		foreach(config('optimage') as $key => $item) {
			Storage::disk('public')->delete('uploads/'.$medium->filehash.'_'.$key.'.'.$medium->extension);
		}
	}

	/** Remove all optimized copies for ALL media */
	public function cleanAll() {
		$files = Storage::disk('public')->files('uploads/');
		
		// Filtering out original files
		$originals = array_filter($files, function($item) {
			return !preg_match('/^uploads\/([A-Za-z0-9]{40})\.(jpg|gif|jpeg|png)$/', $item);
		});

		foreach($originals as $path) {
			Storage::disk('public')->delete($path);
		}

		return redirect(route('media'));
	}

	/** Remove all optimized copies and rebuild everything. Usefull when changing optimage config. */
	public function forceRebuild() {
		$this->cleanAll();
		$this->rebuildAll();
		return redirect(route('media'));
	}
}