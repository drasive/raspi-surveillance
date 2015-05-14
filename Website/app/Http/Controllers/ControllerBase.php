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
		$hostIpAddress = gethostbyname(gethostname());
		$hostTime = date("c", time());

		View::share('global_hostName', $hostName);
		View::share('global_hostIpAddress', $hostIpAddress);
		View::share('global_hostTime', $hostTime);
	}

}
