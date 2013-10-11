<?php

use Illuminate\Database\Migrations\Migration;

class CreateFeedTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('sites', function($table){
			$table->increments('id');
			$table->string('name');
			$table->string('url')->unique();
			$table->string('url_feed');
			$table->timestamps();
		});
		
		Schema::create('feeds', function($table){
			$table->bigIncrements('id');
			$table->integer('site_id')->unsigned()->nullable();
			$table->string('hash', 40)->unique();
			$table->string('name');
			$table->string('url');
			$table->integer('score');
			$table->timestamps();
			
			$table->foreign('site_id')->references('id')->on('sites')->onDelete('set null');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('feeds');
		Schema::drop('sites');
	}

}