<?php namespace RaspiSurveillance;

use Illuminate\Database\Eloquent\Model;
use Validator;

/**
* Represents the host settings.
*/
class Settings {

	// Members
	public $camera_mode;

	// Methods
	public function getValidator()
	{
		return Validator::make(
			array(
				'camera_mode' => $this->camera_mode
			),
			array(
				'camera_mode' => 'required|numeric|min:0|max:2'
			)
		);
	}

}
