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
    {
        Schema::create('show_times', function (Blueprint $table) {
            $table->bigIncrements('SHT_id');
              $table->unsignedBigInteger('SH_id');
             
              $table->time('start_time')->nullable();
              $table->time('end_time')->nullable();
            
              
          $table->unsignedBigInteger('PU_id')->nullable();
       
              $table->timestamps();




          
            $table->foreign('SH_id')
            ->references('SH_id') // Match the column name in the role table
            ->on('shows')
            ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('PU_id')->references('PU_id')->on('public_offers')->onDelete('cascade')->onUpdate('cascade');
 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('showtimes');
    }
};
