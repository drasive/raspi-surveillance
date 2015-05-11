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
	
	protected $size;
	public function getSize()
	{
		return $this->size;
	}
	
	// TODO: On Linux, only updated_at exists and can be set by create(). Decide to keep both/ ditch created_at.
	protected $created_at;
	public function getCreatedAt()
	{
		return $this->created_at;
	}
	
	protected $updated_at;
	public function getUpdatedAt()
	{
		return $this->updated_at;
	}
	
	// Constructors
	public function __construct($path)
	{
		$this->path = $path;
		$this->doesExist = file_exists($this->getPath());
		
		if ($this->getDoesExist()) {
			$this->size = filesize($this->getPath());
			$this->created_at = filectime($this->getPath());
			$this->updated_at = filemtime($this->getPath());
		}
	}
	
	// Methods
	/**
	* Creates a file with the specified filename, size and modification date.
	* Existing files will be overwritten and the content is always random ASCII characters, independent of the extension.
	* 
	* @param string $filename The name of the file to create.
	* @param int $size The size of the file to create in bytes.
	* @param timestamp $updated_at The modification date to set for the created file.
	*/
	public static function create($filename, $size = 0, $updated_at = NULL) {
		//$filename = 'C:\temp\raspi' . DIRECTORY_SEPARATOR . $filename;
		
		if (is_null($updated_at)) {
			$updated_at = time();
		}
		
		// Clear existing content if the file already exists, so we can set a custom size
		if (file_exists($filename)) {
			file_put_contents($filename, "");
		}
		
		// Open file in write only mode
		$file = fopen($filename, 'w');
		
		// Write a dummy character to achieve the specified size
		if ($size > 0) {
			fseek($file, $size - 1, SEEK_CUR);
			fwrite($file,'a');
		}
		
		// Close file
		fclose($file);
		
		// Update the modification date
		touch($filename, $updated_at);
	}
	
	public function delete() {
		if (file_exists($this->getPath())) {
			unlink($this->getPath());
			return true;
		}
		else {
			return false;
		}
	}

}
