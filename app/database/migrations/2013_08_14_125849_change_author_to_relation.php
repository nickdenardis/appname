<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class ChangeAuthorToRelation extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		// Add the author_id to the posts table
		Schema::table('posts', function($table)
		{
		    $table->integer('author_id');
		    $table->dropColumn('author_name');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		// Remove the author_id column
		Schema::table('posts', function($table)
		{
		    $table->dropColumn('author_id');
		    $table->string('author_name');
		});
	}

}