<?php namespace RaspiSurveillance;

/**
* Represents a surveillance video file.
*/
class Video extends FileModelBase {

	// Members and Getters
	public function getDuration()
	{
		// TODO:
		return 120;
	}
	
	// Constructors
	public function __construct($filename)
	{
		parent::__construct(self::getBaseDirectory() . $filename);
	}
	
	// Methods
	public static function getBaseDirectory() {
		$baseDirectory = env('VIDEO_DIRECTORY', 'videos');
		return realpath($baseDirectory) . DIRECTORY_SEPARATOR;
	}
	
	public static function getFileExtension() {
		return env('VIDEO_EXTENSION', '*.mp4');;
	}
	
	
	public static function create($filename, $size = 0, $updatedAt = NULL) {
		$filepath = self::getBaseDirectory() . $filename;
		parent::create($filepath, $size, $updatedAt);
	}

}
