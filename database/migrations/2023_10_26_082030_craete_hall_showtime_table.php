<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {  Schema::create('hall_showtime', function (Blueprint $table) {
        $table->bigIncrements('HS_id');
        $table->unsignedBigInteger('H_id');
        $table->unsignedBigInteger('SHT_id');
       
          // Define the foreign key constraint
      $table->foreign('SHT_id')
      ->references('SHT_id') // Match the column name in the role table
      ->on('show_times')
      ->onDelete('cascade')->onUpdate('cascade');
        // Define the foreign key constraint
        $table->foreign('H_id')
        ->references('H_id') // Match the column name in the role table
        ->on('halls')
        ->onDelete('cascade')->onUpdate('cascade');

      
    });}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hall_showtime');
    }
};
