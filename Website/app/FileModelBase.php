<?php namespace RaspiSurveillance;

/**
* Base class for models representing files.
*/
abstract class FileModelBase {

	// Members and Getters
	protected $path;
	public function getPath()
	{
		return $this->path;
	}
	
	protected $doesExist;
	public function getDoesExist()
	{
		return $this->doesExist;
	}
	
	// Constructors
	public function __construct($path)
	{
		$this->path = $path;
		$this->doesExist = file_exists($this->path);
	}
	
	// Methods
	public function delete() {
		if (file_exists($this->path)) {
			unlink($this->path);
			return true;
		}
		else {
			return false;
		}
	}

}
