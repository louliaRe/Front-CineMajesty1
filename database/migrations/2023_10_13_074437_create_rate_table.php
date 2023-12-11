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
        Schema::create('rates', function (Blueprint $table) {
            
            $table->bigIncrements('RA_id');

            $table->unsignedBigInteger('F_id');
            $table->unsignedBigInteger('C_id');
            $table->integer('value');
            
            $table->timestamps();
        
            // Define the foreign key constraint
            $table->foreign('C_id')
                  ->references('C_id') // Match the column name in the role table
                  ->on('customers')
                  ->onDelete('cascade')->onUpdate('cascade');
                  // Define the foreign key constraint
                  $table->foreign('F_id')
                        ->references('F_id') // Match the column name in the role table
                        ->on('films')
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
        Schema::dropIfExists('rate');
    }
};
