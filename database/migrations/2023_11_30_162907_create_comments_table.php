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
        Schema::create('comments', function (Blueprint $table) {
           
            $table->bigIncrements('CO_id');
            $table->unsignedBigInteger('C_id'); // Assuming this is a foreign key to the snack table
            $table->unsignedBigInteger('F_id'); // Assuming this is a foreign key to the booking table
            $table->text('comments');
            $table->timestamps();
            $table->foreign('F_id')
            ->references('F_id') // Match the column name in the role table
            ->on('films')
            ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('C_id')
            ->references('C_id') // Match the column name in the role table
            ->on('customers')
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
        Schema::dropIfExists('comments');
    }
};
