<?php namespace RaspiSurveillance\Http\Controllers;

use RaspiSurveillance\Http\Requests;

use Illuminate\Http\Request;
use Input;
use Response;

use RaspiSurveillance\Camera;

class ApiCameraController extends ControllerBase {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		try {
			$cameras = Camera::all();
			
			// Sort by id, lowest to highest
			$cameras = $cameras->sortBy(function ($camera) {
				return $camera->id;
			});
			
			return $cameras->toJson();
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
			$camera = new Camera();
			$camera->ip_address = Input::get('ip_address');
			$camera->name       = Input::get('name');
			
			// Validate input
			$validator = $camera->getValidator();
			if ($validator->fails()) {
				return Response($validator->messages(), 400);
			}
			
			// Check if model already exists
			$existingCamera = Camera::where('ip_address', '=', $camera->ip_address)->get();
			if (!is_null($existingCamera)) {
				return Response("", 400);
			}
			
			$camera->save();
		}
		catch (Exception $exception) {
			return Response($exception, 500);
		}
		
		return Response("", 200);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		try {
			$camera = Camera::find($id);
			
			if (!is_null($camera)) {
				return $camera->toJson();
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
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		try {
			$camera = Camera::find($id);
			
			if (!is_null($camera)) {
				$camera->ip_address = Input::get('ip_address');
				$camera->name       = Input::get('name');
				
				// Validate input
				$validator = $camera->getValidator();
				if ($validator->fails()) {
					return Response($validator->messages(), 400);
				}
				
				// Check if model already exists
				$existingCamera = Camera::
				    where('id', '!=', $camera->id)
				  ->where('ip_address', '=', $camera->ip_address)->first();
				if (!is_null($existingCamera)) {
					return Response("", 400);
				}
				
				$camera->save();
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

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		try {
			$camera = Camera::find($id);
			
			if (!is_null($camera)) {
				$camera->delete();
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
