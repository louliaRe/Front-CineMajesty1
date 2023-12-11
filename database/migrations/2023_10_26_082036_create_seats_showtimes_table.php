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
        Schema::create('seat_showtime', function (Blueprint $table) {
            $table->bigIncrements('SS_id');

              $table->unsignedBigInteger('SE_id');
            $table->unsignedBigInteger('HS_id');
        

            $table->enum('status',['available','booked'])->default('available');
            $table->timestamps();
           
            
        
            // Define the foreign key constraint
            $table->foreign('SE_id')
                  ->references('SE_id') // Match the column name in the role table
                  ->on('seats')
                  ->onDelete('cascade')->onUpdate('cascade');
                  // Define the foreign key constraint
                  $table->foreign('HS_id')
                        ->references('HS_id') // Match the column name in the role table
                        ->on('hall_showtime')
                        ->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('seats_showtimes');
    }
};
