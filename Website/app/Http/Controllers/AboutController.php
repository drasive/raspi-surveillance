<?php namespace RaspiSurveillance\Http\Controllers;

use RaspiSurveillance\Http\Requests;
use RaspiSurveillance\Http\Controllers\Controller;

use Illuminate\Http\Request;
use View;

class AboutController extends Controller {

	public function index()
	{
		return View::make('about');
	}

}
