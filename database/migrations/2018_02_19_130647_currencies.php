<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Currencies extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    Schema::create('currencies', function (Blueprint $table) {
		    $table->engine = 'InnoDB';
		    $table->increments('id');
		    $table->string('pair')->nullable();
		    $table->string('price')->nullable();
		    $table->string('timestamp')->nullable();
		    $table->timestamps();
	    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
	    Schema::drop('currencies');
    }
}
