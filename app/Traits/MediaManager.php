<?php

namespace App\Traits;


use Illuminate\Http\UploadedFile;
use App\Http\Helpers\ImageOptimizer;
use App\Models\Medium;


/**
 * Helper for processing media uploads.
 */
trait MediaManager {

	/**
	 * Saves an uploaded file to disk and to media library and genrates optimized versions. Files are stored with an hashed name.
	 * @param Illuminate\Http\UploadedFile $file File to save.
	 * @param array $options Options for storing the file :
	 * @param string $options['family'] The sub directory in storage/ where the file is stored. Optional, default to uploads/.
	 * @param string $options['name'] The new name of the file. Optional, default to original file name without the extension.
	 * @return string The medium id that has been saved.
	 */
	public static function storeMedia(UploadedFile $file, array $options = []) {

		// Set default name (not filename) if not provided
		if(!array_key_exists('name', $options) || (array_key_exists('name', $options) && !$options['name'])) {
			// Strip away extension
			$options['name'] = implode('.', explode('.', $file->getClientOriginalName(), -1));
		}

		// Set default directory if not provided
		if(!array_key_exists('family', $options)) {
			$options['family'] = 'uploads';
		}

		// Get filename, hashname and extension
		// filename = hashname.ext
		$fileName = $file->hashName();
		$fileInfo = explode('.', $fileName);

		// Store file
		$filePath = $file->storeAs($options['family'], $fileInfo[0].'.'.$fileInfo[1], 'public');
		
		// Generate optimized copies
		ImageOptimizer::run($filePath);

		// Save into database
		$medium = auth()->user()->media()->create([
			'filehash' => $fileInfo[0],
			'extension' => $fileInfo[1],
			'name' => $options['name'],
		]);

		return $medium->getAttribute('id');
	}

	public function refresh(Medium $medium) {
		ImageOptimizer::run('uploads/'.$medium->filename);
		return redirect(route('media.display', $medium));
	}

	public function refreshAll() {
		ImageOptimizer::runAll('uploads');
		return redirect(route('media'));
	}

	public function rebuild(Medium $medium) {
		ImageOptimizer::clean('uploads/'.$medium->filename);
		ImageOptimizer::run('uploads/'.$medium->filename);
		return redirect(route('media.display', $medium));
	}

	public function rebuildAll() {
		ImageOptimizer::cleanAll('uploads');
		ImageOptimizer::runAll('uploads');
		return redirect(route('media'));
	}
}