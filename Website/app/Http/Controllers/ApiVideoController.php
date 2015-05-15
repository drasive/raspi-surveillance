<?php namespace RaspiSurveillance\Http\Controllers;

use RaspiSurveillance\Http\Requests;

use Illuminate\Http\Request;
use Input;
use Response;

use RaspiSurveillance\Video;

/**
* REST API controller for the Video model.
*/
class ApiVideoController extends ApiControllerBase {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		try {
			// Get model files (sorted so new videos are first)
			$videoFiles = glob('videos/*.mp4');
			
			// Instantiate objects
			$videos = array();
			foreach ($videoFiles as $videoFile) {
				$filename = basename($videoFile);
				$video = new Video($filename);
				
				$videos[] = self::JsonEncode($video);
			}
			
			return json_encode($videos);
		}
		catch (Exception $exception) {
			return Response($exception, 500);
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($filename)
	{
		try {
			$video = new Video($filename);
			
			if ($video->getExists()) {
				return self::JsonEncode($video);
			}
			else {
				return Response("", 404);
			}
		}
		catch (Exception $exception) {
			return Response($exception, 500);
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($filename)
	{
		try {
			$video = new Video($filename);
			
			if ($video->getExists()) {
				$video->delete();
			}
			else {
				return Response("", 404);
			}
		}
		catch (Exception $exception) {
			return Response($exception, 500);
		}
		
		return Response("", 200);
	}

	
	protected static function JsonEncode($video) {
		return array(
		    'filename'   => basename($video->getPath()),
		    'duration'   => $video->getDuration(),
		    'size'       => $video->getSize(),
		    'created_at' => date("c", $video->getCreatedAt()),
		    'updated_at' => date("c", $video->getUpdatedAt())
		);
	}
	
}
