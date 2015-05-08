<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use RaspiSurveillance\Camera;

class CameraTableSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();		
		DB::table('cameras')->delete();

		Camera::create(['ip_address' => '192.168.0.149',   'name' => 'Felix Young']);
		Camera::create(['ip_address' => '192.168.1.243',   'name' => 'Vicky Cain']);
		Camera::create(['ip_address' => '192.168.01.165',  'name' => 'Kate Andrews']);		
		Camera::create(['ip_address' => '192.168.012.56',  'name' => 'Samuel Thompson']);
		Camera::create(['ip_address' => '192.168.12.92',   'name' => 'Loretta Garrett']);
		Camera::create(['ip_address' => '192.168.12.254',  'name' => 'Ruth Bush']);
		Camera::create(['ip_address' => '192.168.255.253', 'name' => 'Sarah Hall']);
		Camera::create(['ip_address' => '172.16.0.3',      'name' => 'Jorge Marsh']);
		Camera::create(['ip_address' => '172.16.1.1',      'name' => 'Sergio Mann']);
		Camera::create(['ip_address' => '172.17.0.1',      'name' => 'Jean Dean']);		
		Camera::create(['ip_address' => '10.1.2.3',        'name' => 'Rosa Pratt']);
		Camera::create(['ip_address' => '10.255.00.34',    'name' => 'Elias Flores']);
	}

}
