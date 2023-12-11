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
        Schema::create('seats', function (Blueprint $table) {
            $table->bigIncrements('SE_id');
            $table->unsignedBigInteger('H_id');         
              $table->string('seat_num');
              $table->integer('seat_row');
              $table->integer('seat_col');
              $table->timestamps();

            // Define the foreign key constraint
            $table->foreign('H_id')
                  ->references('H_id') // Match the column name in the role table
                  ->on('halls') ->onDelete('cascade')->onUpdate('cascade');;
                

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('seats');
    }
};