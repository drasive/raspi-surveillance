<?php namespace RaspiSurveillance;

/**
* Represents a surveillance video file.
*/
class Video extends FileModelBase {

	// Members and Getters
	protected $creation_date;
	public function getCreationDate()
	{
		return $this->creation_date;
	}
	
	protected $duration;
	public function getDuration()
	{
		return $this->duration;
	}
	
	protected $size;
	public function getSize()
	{
		return $this->size;
	}
	
	// Constructors
	public function __construct($path)
	{
		parent::__construct($path);
		
		if ($this->getDoesExist()) {
			$this->creation_date = time() - 5 * 60 * 1000; // TODO:
			$this->duration = 120; // TODO:
			$this->size = filesize($this->path);
		}
	}

}
