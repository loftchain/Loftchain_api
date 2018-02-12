<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBtcTxTable extends Migration
{

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('btcTx', function (Blueprint $table) {
      $table->increments('id');
      $table->string('txId')->nullable();
      $table->string('from')->nullable();
      $table->double('amount')->nullable();
      $table->dateTime('date')->nullable();
      $table->string('status')->nullable();
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
    Schema::drop('btcTx');
  }

}
