<?php namespace RaspiSurveillance\Http\Controllers;

use RaspiSurveillance\Http\Requests;

use Illuminate\Http\Request;
use View;

/**
* Controller for the video archive page.
*/
class VideoArchiveController extends ControllerBase {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return View::make('video-archive');
	}

}
