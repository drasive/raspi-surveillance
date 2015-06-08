<?php namespace RaspiSurveillance;

/**
* Base class for models that represent files.
*/
abstract class FileModelBase {

	// Members and Getters
	protected $path;
	public function getPath()
	{
		return realpath($this->path);
	}
	
	public function getExists()
	{
		return file_exists($this->getPath());
	}
	
	public function getSize()
	{
		if ($this->getExists()) {
			return filesize($this->getPath());
		}
		
		return NULL;
	}
	
	public function getCreatedAt()
	{
		if ($this->getExists()) {
			return filectime($this->getPath());
		}
		
		return NULL;
	}
	
	public function getUpdatedAt()
	{
		if ($this->getExists()) {
			return filemtime($this->getPath());
		}
		
		return NULL;
	}
	
	// Constructors
	public function __construct($path)
	{
		$this->path = $path;
	}
	
	// Methods
	/**
	* Deletes the file represented by this instance permanently from the file system.
	*/
	public function delete() {
		if ($this->getExists()) {
			unlink($this->getPath());
		}
	}

}
