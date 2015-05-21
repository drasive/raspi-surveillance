<?php namespace RaspiSurveillance\Http\Controllers;

use RaspiSurveillance\Http\Requests;

use Illuminate\Http\Request;
use View;

/**
* Controller for the livestream page.
*/
class LivestreamController extends ControllerBase {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return View::make('livestream');
	}

}
