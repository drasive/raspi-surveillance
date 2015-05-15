<?php namespace RaspiSurveillance;

/**
* Represents a surveillance video file.
*/
class Video extends FileModelBase {

	// Members and Getters
	protected $fileInfo;
	public function getFileInfo() {
		if (is_null($this->fileInfo)) {
			$getID3 = new \getID3;
			$this->fileInfo = $getID3->analyze($this->getPath());
		}

		return $this->fileInfo;
	}

	public function getDuration()
	{
		return $this->getFileInfo()['playtime_seconds'];
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
