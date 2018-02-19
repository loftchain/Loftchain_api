<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Transactions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    Schema::create('transactions', function (Blueprint $table) {
		    $table->engine = 'InnoDB';
		    $table->increments('id');
		    $table->integer('customer_id')->unsigned();
		    $table->string('currency')->nullable();
		    $table->string('txId')->nullable();
		    $table->string('from')->nullable();
		    $table->double('amount')->nullable();
		    $table->dateTime('date')->nullable();
		    $table->string('status')->nullable();
		    $table->timestamps();
		    $table->foreign('customer_id')->references('customer_id')->on('customers')->onDelete('cascade');
	    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
