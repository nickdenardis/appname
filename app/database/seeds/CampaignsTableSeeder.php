<?php

class CampaignsTableSeeder extends Seeder {

	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
		// DB::table('campaigns')->truncate();

		$campaigns = array(
			array(
	        'title'    => 'Test Campaign',
	        'description'   => 'Lorem ipsum Reprehenderit velit est irure in enim in magna aute occaecat qui velit ad.',
	        'created_at' => date('Y-m-d H:i:s'),
	        'updated_at' => date('Y-m-d H:i:s'),
	      ),
	      array(
	        'title'    => 'Another Test Campaign',
	        'description'   => 'Lorem ipsum Reprehenderit velit est irure in enim in magna aute occaecat qui velit ad.',
	        'created_at' => date('Y-m-d H:i:s'),
	        'updated_at' => date('Y-m-d H:i:s'),
	      ),

		);

		// Uncomment the below to run the seeder
		DB::table('campaigns')->insert($campaigns);
	}

}
