<?php namespace RaspiSurveillance;

/**
* Base class for models representing files.
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
	
	// TODO: On Linux, only updated_at exists and can be set by create(). Decide to keep both/ ditch created_at.
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
	// TODO: Move these somewhere
	/**
	* Creates a file with the specified filename, size and modification date.
	* Existing files will be overwritten and the content is always random ASCII characters, independent of the extension.
	* 
	* @param string $filename The name of the file to create.
	* @param int $size The size of the file to create in bytes.
	* @param timestamp $updated_at The modification date to set for the created file.
	*/
	public static function create($path, $size = 0, $updatedAt = NULL) {
		if (is_null($updatedAt)) {
			$updatedAt = time();
		}
		
		// TODO: Implement
		// This method is usually called from /app, use /public as base directory
		echo $path;
		
		// Clear existing content if the file already exists, so we can set a custom size
		if (file_exists($path)) {
			file_put_contents($path, "");
		}
		
		// Open file in write only mode
		$file = fopen($path, 'w');
		
		// Write a dummy character to achieve the specified size
		if ($size > 0) {
			fseek($file, $size - 1, SEEK_CUR);
			fwrite($file,'a');
		}
		
		// Close file
		fclose($file);
		
		// Update the modification date
		touch($path, $updatedAt);
	}
	
	/**
	* Deletes the file represented by this instance permanently from the file system.
	*/
	public function delete() {
		if ($this->getExists()) {
			unlink($this->getPath());
		}
	}

}
