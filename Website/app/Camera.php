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
				'port      ' => $this->port,
				'name'       => $this->name
			),
			array(
				'ip_address' => 'required|ip',
				'port      ' => 'min:0|max:65535',
				'name'       => 'between:0,32',
			)
		);
	}

}
