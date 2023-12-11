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
        Schema::create('tickets', function (Blueprint $table) {
            $table->bigIncrements('T_id');
              $table->unsignedBigInteger('B_id');
              $table->unsignedBigInteger('SS_id');

                // Define the foreign key constraint
            $table->foreign('B_id')
            ->references('B_id') // Match the column name in the role table
            ->on('bookings')
            ->onDelete('cascade')->onUpdate('cascade');
              // Define the foreign key constraint
              $table->foreign('SS_id')
              ->references('SS_id') // Match the column name in the role table
              ->on('seat_showtime')
              ->onDelete('cascade')->onUpdate('cascade');

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
        Schema::dropIfExists('tickets');
    }
};
