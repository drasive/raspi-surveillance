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
		parent::__construct('videos/' . $filename);
	}
	
	// Methods	
	public static function create($filename, $size = 0, $updatedAt = NULL) {
		$filepath = 'videos/' . $filename;
		parent::create($filepath, $size, $updatedAt);
	}

}
