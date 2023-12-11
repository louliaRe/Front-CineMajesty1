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
        Schema::create('images', function (Blueprint $table) {
            $table->bigIncrements('IM_id');
            $table->unsignedBigInteger('F_id')->nullable();  
            $table->unsignedBigInteger('S_id')->nullable();
            $table->string('image_path');
            $table->foreign('F_id')
            ->references('F_id') // Match the column name in the role table
            ->on('films')
            ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('S_id')
            ->references('S_id') // Match the column name in the role table
            ->on('snacks')
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
        Schema::dropIfExists('images');
    }
};
