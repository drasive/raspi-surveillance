<?php

use Illuminate\Database\Seeder;

use RaspiSurveillance\Video;

class VideoFileSeeder extends Seeder {

	/**
	 * Run the file seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Video::create('2014-11-24_04-55-17.mp4', 1.4 * 1024 * 1024, strtotime('2014-11-24 04:55:17'));
		Video::create('2014-12-02_11-46-54.mp4', 2.6 * 1024 * 1024, strtotime('2014-12-02 11:46:54'));
		Video::create('2015-02-20_07-36-03.mp4', 0.7 * 1024 * 1024, strtotime('2015-02-20 07:36:03'));
		Video::create('2015-03-31_05-21-28.mp4', 5.3 * 1024 * 1024, strtotime('2015-03-31 05:21:28'));
		Video::create('2015-04-29_12-11-34.mp4', 4.7 * 1024 * 1024, strtotime('2015-04-29 12:11:34'));
		Video::create('2015-05-03_21-40-58.mp4', 5.6 * 1024 * 1024, strtotime('2015-05-03 21:40:58'));
		Video::create('2015-05-04_00-13-03.mp4', 0.3 * 1024 * 1024, strtotime('2015-05-04 00:13:03'));
		Video::create('2015-05-19_19-26-43.mp4', 5.0 * 1024 * 1024, strtotime('2015-05-19 19:26:43'));
		Video::create('2015-06-21_04-16-47.mp4', 1.3 * 1024 * 1024, strtotime('2015-06-21 13:16:47'));
		Video::create('2015-06-15_11-57-22.mp4', 5.7 * 1024 * 1024, strtotime('2015-06-15 11:57:22'));
		Video::create('2016-01-26_15-49-39.mp4', 2.8 * 1024 * 1024, strtotime('2016-01-26 15:49:39'));
		Video::create('2016-10-05_01-12-12.mp4', 6.7 * 1024 * 1024, strtotime('2016-10-05 01:12:12'));
	}

}
