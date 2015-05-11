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

		Camera::create(['ip_address' => '192.168.0.149',   'port' => '8554',  'name' => 'Felix Young']);
		Camera::create(['ip_address' => '192.168.1.243',   'port' => '8554',  'name' => 'Vicky Cain']);
		Camera::create(['ip_address' => '192.168.1.243',   'port' => '12423', 'name' => 'Kate Andrews']);		
		Camera::create(['ip_address' => '192.168.012.56',  'port' => '8554',  'name' => '']);
		Camera::create(['ip_address' => '192.168.12.92',   'port' => '1946',  'name' => 'Loretta Garrett']);
		Camera::create(['ip_address' => '192.168.12.92',   'port' => '8554',  'name' => 'Ruth Bush']);
		Camera::create(['ip_address' => '192.168.255.253', 'port' => '13429', 'name' => 'Sarah Hall']);
		Camera::create(['ip_address' => '172.16.0.3',      'port' => '15817', 'name' => '']);
		Camera::create(['ip_address' => '172.16.1.1',      'port' => '6397',  'name' => 'Sergio Mann']);
		Camera::create(['ip_address' => '172.17.0.1',      'port' => '27860', 'name' => 'Jean Dean']);		
		Camera::create(['ip_address' => '10.1.2.3',        'port' => '17789', 'name' => 'Rosa Pratt']);
		Camera::create(['ip_address' => '10.255.00.34',    'port' => '36467', 'name' => 'Elias Flores']);
	}

}
