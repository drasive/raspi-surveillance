<?php namespace RaspiSurveillance;

use Illuminate\Database\Eloquent\Model;
use Validator;

/**
* Represents a surveillance camera connection.
*/
class Camera extends Model {

	public function getValidator()
	{
		return Validator::make(
			array(
				'ip_address' => $this->ip_address,
				'name'       => $this->name
			),
			array(
				'ip_address' => 'required|ip',
				'name'       => 'between:0,32',
			)
		);
	}

}
