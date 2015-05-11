<?php

use Illuminate\Database\Seeder;

class FilesystemSeeder extends Seeder {

	/**
	 * Run the filesystem seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$this->call('VideoFileSeeder');
	}

}
