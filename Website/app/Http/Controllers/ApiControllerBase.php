<?php namespace RaspiSurveillance\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;

/**
* Base class for API controllers.
*/
abstract class ApiControllerBase extends BaseController {

	use DispatchesCommands, ValidatesRequests;

}
