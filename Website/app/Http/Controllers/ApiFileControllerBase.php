<?php namespace RaspiSurveillance\Http\Controllers;

use RaspiSurveillance\Http\Requests;

use Illuminate\Http\Request;
use Response;

/**
* Base class for API controllers that manage file models.
*/
abstract class ApiFileControllerBase extends ControllerBase {

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		// This method is not supported for file controllers
		return Response("", 400);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		// This method is not supported for file controllers
		return Response("", 400);
	}

}
