<?php namespace RaspiSurveillance\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;

use View;

/**
* Base class for controllers.
*/
abstract class ControllerBase extends BaseController {

	use DispatchesCommands, ValidatesRequests;
	
	public function __construct() 
	{
		$hostName = gethostname();        
		$hostIpAddress = isset($_SERVER['SERVER_ADDR']) ? $_SERVER['SERVER_ADDR'] : gethostbyname(gethostname());
		$hostTime = date("c", time());

		View::share('g_hostName', $hostName);
		View::share('g_hostIpAddress', $hostIpAddress);
		View::share('g_hostTime', $hostTime);
	}

}
