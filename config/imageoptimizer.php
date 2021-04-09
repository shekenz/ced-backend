<?php

return [

	'uploads' => [
		'thumb' => [
			'caption' => 'thumbnail',
			'width' => 100,
			'height' => 100,
			'quality' => 50,
			'upsize' => true,
		],

		'thumb2x' => [
			'caption' => 'thumbnail @2x',
			'width' => 200,
			'height' => 200,
			'quality' => 50,
			'upsize' => true,
		],

		'md' => [
			'caption' => 'medium',
			'width' => 640,
			'height' => 360,
			'quality' => 80,
			'upsize' => false,
		],

		'hd' => [
			'caption' => 'HD',
			'width' => 1280,
			'height' => 720,
			'quality' => 80,
			'upsize' => false,
		],
	],
	'profiles' => [
		'thumb' => [
			'caption' => 'thumbnail',
			'width' => 200,
			'height' => 200,
			'quality' => 80,
			'upsize' => true,
		],

		'thumb2x' => [
			'caption' => 'thumbnail @2x',
			'width' => 400,
			'height' => 400,
			'quality' => 80,
			'upsize' => true,
		],
	],
];