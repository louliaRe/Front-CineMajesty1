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
        Schema::create('halls', function (Blueprint $table) {
            $table->bigIncrements('H_id');
            $table->integer('total_seats');
            $table->unsignedBigInteger('TY_id');
           
            $table->foreign('TY_id')
            ->references('TY_id') // Match the column name in the role table
            ->on('types')
            ->onDelete('cascade')->onUpdate('cascade');
            $table->enum('status',['available','unavailable'])->default('available');
            $table->integer('price');
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
        Schema::dropIfExists('halls');
    }
};
