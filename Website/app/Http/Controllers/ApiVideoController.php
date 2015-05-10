<?php namespace RaspiSurveillance\Http\Controllers;

use RaspiSurveillance\Http\Requests;

use Illuminate\Http\Request;
use Input;
use Response;

use RaspiSurveillance\Video;

class ApiVideoController extends ApiFileControllerBase {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		try {
			// Get model files (sorted so new videos are first)
			$videoDirectory = env('VIDEO_DIRECTORY', 'videos') . DIRECTORY_SEPARATOR;
			$videoExtension = env('VIDEO_EXTENSION', '*.mp4');
			
			$videoFiles = glob($videoDirectory . $videoExtension);
			dd(dirname(__FILE__)); 
			// Instantiate objects
			$videos = array();
			foreach ($videoFiles as $videoFile) {
				$video = new Video($videoFile);
				$videos[] = array(
				    'path'          => $video->getPath(),
					'creation_date' => $video->getCreationDate(),
					'duration'      => $video->getDuration(),
					'size'          => $video->getSize()
				);
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
			
			if ($video->getDoesExist()) {
				return json_encode($video);
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
			
			if ($video->getDoesExist()) {
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

}
