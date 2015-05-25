<?php namespace RaspiSurveillance\Http\Controllers;

use RaspiSurveillance\Http\Requests;

use Illuminate\Http\Request;
use View;

/**
* Controller for the about page.
*/
class AboutController extends ControllerBase {

	public function index()
	{
		return View::make('about');
	}

}
