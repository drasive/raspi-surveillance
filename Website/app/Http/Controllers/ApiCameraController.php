<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Camera;

class ApiCameraController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		// Get all cameras
		$cameras = Camera::all();
		
		// Sort events by IP-address, lowest to highest
        $cameras = $cameras->sortByDesc(function ($camera) {
            return str_replace(".", "", $camera); // Use numeric value of IPv4 address
        });
		
		// Return list of cameras (URL and id as values)
		foreach ($cameras as $camera) {
            // code
        }
		return response()->json(['name' => 'Abigail', 'state' => 'CA']);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		// Create
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		// Get by id
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		// Update
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
			Camera::destroy($id);			
			
			//$camera = Camera::find($id);
			//$camera->delete();
		}
		catch (Exception $exception) {
			return new Response($exception->getMessage(), 500);
		}
		
		return new Response("", 200);
	}

}
