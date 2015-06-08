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

		Camera::create(['ip_address' => '192.168.0.149',   'port' => '8554',  'protocol' => 'http', 'name' => 'Felix Young']);
		Camera::create(['ip_address' => '192.168.1.243',   'port' => '8554',  'protocol' => 'http', 'name' => 'Vicky Cain']);
		Camera::create(['ip_address' => '192.168.1.243',   'port' => '12423', 'protocol' => 'http', 'name' => 'Kate Andrews']);		
		Camera::create(['ip_address' => '192.168.12.56',   'port' => '8554',  'protocol' => 'rtsp', 'name' => '']);
		Camera::create(['ip_address' => '192.168.12.92',   'port' => '1946',  'protocol' => 'http', 'name' => 'Loretta Garrett']);
		Camera::create(['ip_address' => '192.168.12.92',   'port' => '8554',  'protocol' => 'http', 'name' => 'Ruth Bush']);
		Camera::create(['ip_address' => '192.168.255.253', 'port' => '13429', 'protocol' => 'rtsp', 'name' => 'Sarah Hall']);
		Camera::create(['ip_address' => '172.16.0.3',      'port' => '15817', 'protocol' => 'http', 'name' => '']);
		Camera::create(['ip_address' => '172.16.1.1',      'port' => '6397',  'protocol' => 'rtsp', 'name' => 'Sergio Mann']);
		Camera::create(['ip_address' => '172.17.0.1',      'port' => '27860', 'protocol' => 'http', 'name' => 'Jean Dean']);		
		Camera::create(['ip_address' => '10.1.2.3',        'port' => '17789', 'protocol' => 'rtsp', 'name' => 'Rosa Pratt']);
		Camera::create(['ip_address' => '10.255.0.34',     'port' => '36467', 'protocol' => 'rtsp', 'name' => 'Elias Flores']);
	}

}
