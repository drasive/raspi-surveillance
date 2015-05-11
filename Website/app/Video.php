<?php namespace RaspiSurveillance;

/**
* Represents a surveillance video file.
*/
class Video extends FileModelBase {

	// Members and Getters
	protected $duration;
	public function getDuration()
	{
		return $this->duration;
	}
	
	// Constructors
	public function __construct($path)
	{
		parent::__construct($path);
		
		if ($this->getDoesExist()) {
			// TODO:
			$this->duration = 120;
		}
	}

}
