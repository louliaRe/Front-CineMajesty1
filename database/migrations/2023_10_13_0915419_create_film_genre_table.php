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
        Schema::create('film_genre', function (Blueprint $table) {
            $table->bigIncrements('FG_id');
            $table->unsignedBigInteger('F_id');
            $table->unsignedBigInteger('G_id');

            $table->foreign('G_id')
            ->references('G_id') // Match the column name in the role table
            ->on('genres')
            ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('F_id')
            ->references('F_id') // Match the column name in the role table
            ->on('films')
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
        Schema::dropIfExists('film_genre');
    }
};
