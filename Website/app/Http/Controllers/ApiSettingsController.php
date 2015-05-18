<?php namespace RaspiSurveillance\Http\Controllers;

use RaspiSurveillance\Http\Requests;

use Illuminate\Http\Request;
use Input;
use Response;
use Exception;

use RaspiSurveillance\Settings;

/**
* REST API controller for settings.
*/
class ApiSettingsController extends ApiControllerBase {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		try {
			// Get properties
			$cameraMode = self::getCameraMode();
			
			// Instantiate object
			$settings = new Settings();
			$settings->camera_mode = $cameraMode;
			
			return self::JsonEncode($settings);
		}
		catch (Exception $exception) {
			return Response($exception, 500);
		}
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		try {
			$input = Input::json();

			$settings = new Settings();
			$settings->camera_mode = $input->get('camera')['mode'];

			// Validate input
			$validator = $settings->getValidator();
			if ($validator->fails()) {
				return Response($validator->messages(), 400);
			}

			// Save properties
			self::saveCameraMode($settings->camera_mode);
		}
		catch (Exception $exception) {
			return Response($exception, 500);
		}
		
		return Response("", 200);
	}


	// Methods
	// TODO:
	protected static function getCameraMode() {
		return 0;
	}

	protected static function saveCameraMode($mode) {
		switch ($mode) {
			case 0:
				self::stopVideostream();
				self::stopMotionDetection();

				break;
			case 1:
				self::stopMotionDetection();
				self::startVideostream();
				
				break;
			case 2:
				self::stopVideostream();
				self::startMotionDetection();

				break;
			default:
				throw new Exception('Unknown camera mode (' . $mode . ')');
		}
	}


	protected static function startVideostream() {
		//shell_exec('sudo ');
	}

	protected static function stopVideostream() {
		//shell_exec('sudo ');
	}

	protected static function startMotionDetection() {
		//shell_exec('sudo ');
	}

	protected static function stopMotionDetection() {
		//shell_exec('sudo ');
	}


	protected static function JsonEncode($settings) {
		return array(
			'camera' => array(
				'mode' => $settings->camera_mode)
		);
	}

}
