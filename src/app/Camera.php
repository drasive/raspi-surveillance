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
				'port'       => $this->port,
				'protocol'   => $this->protocol,
				'name'       => $this->name
			),
			array(
				'ip_address' => 'required|ip',
				'port'       => 'required|numeric|min:0|max:65535',
				'protocol'   => 'required|between:1,5',
				'name'       => 'between:0,64'
			)
		);
	}

}
