<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Customers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    Schema::create('customers', function (Blueprint $table) {
		    $table->engine = 'InnoDB';
		    $table->increments('id');
		    $table->integer('customer_id')->unsigned()->index();
		    $table->string('name')->nullable();
		    $table->string('wallet_currency')->nullable();
		    $table->string('wallet')->nullable();
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
	    Schema::drop('customers');
    }
}
