<?php

class AuthorsTableSeeder extends Seeder {

	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
		// DB::table('authors')->truncate();

		$authors = array(
			array(
				'name'    => 'John Doe',
				'email'   => 'john.doe@gmail.com',
				'website' => 'http://johndoe.com/',
				'created_at' => date('Y-m-d H:i:s'),
				'updated_at' => date('Y-m-d H:i:s'),
			),
			array(
				'name'    => 'Jane Doe',
				'email'   => 'jane.doe@gmail.com',
				'website' => 'http://janedoe.com/',
				'created_at' => date('Y-m-d H:i:s'),
				'updated_at' => date('Y-m-d H:i:s'),
			),
			array(
				'name'    => 'Captain Planet',
				'email'   => 'captian.planet@gmail.com',
				'website' => 'http://captainplanet.com/',
				'created_at' => date('Y-m-d H:i:s'),
				'updated_at' => date('Y-m-d H:i:s'),
			),
		);

		// Uncomment the below to run the seeder
		DB::table('authors')->truncate();
		DB::table('authors')->insert($authors);
	}

}
