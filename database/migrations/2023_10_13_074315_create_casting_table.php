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
        Schema::create('Cast_Film', function (Blueprint $table) {
            

            $table->bigIncrements('CAS_id');
            
            $table->unsignedBigInteger('F_id');
            $table->unsignedBigInteger('CA_id');
            $table->boolean('is_dir');
            $table->boolean('is_act');
            $table->timestamps();
            // Define the foreign key constraint
            $table->foreign('CA_id')
                  ->references('CA_id') // Match the column name in the role table
                  ->on('casts')
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
        Schema::dropIfExists('Cast_Film');
    }
};
