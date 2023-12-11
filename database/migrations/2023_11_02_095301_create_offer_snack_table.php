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
        Schema::create('offer_snack', function (Blueprint $table) {
            $table->bigIncrements('OS_id');
            $table->unsignedBigInteger('PU_id'); // Assuming this is a foreign key to the snack table
            $table->unsignedBigInteger('S_id'); // Assuming this is a foreign key to the booking table

            $table->timestamps();
            $table->foreign('PU_id')
            ->references('PU_id') // Match the column name in the role table
            ->on('public_offers')
            ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('S_id')
            ->references('S_id') // Match the column name in the role table
            ->on('snacks')
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
        Schema::dropIfExists('offer_snack');
    }
};
