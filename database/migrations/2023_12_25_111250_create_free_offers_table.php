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
        Schema::create('free_offers', function (Blueprint $table) {
            $table->bigIncrements('FO_id');
            $table->unsignedBigInteger('S_id');          
            $table->integer('req_amount');
            $table->integer('free_offer');
            $table->date('start_date');
            $table->date('expire_date');
            $table->unsignedBigInteger('free_snack'); 

            $table->foreign('S_id')
            ->references('S_id')
            ->on('snacks')
            ->onDelete('cascade')
            ->onUpdate('cascade');
           
            $table->foreign('free_snack')
            ->references('S_id')
            ->on('snacks')
            ->onDelete('cascade')
            ->onUpdate('cascade');

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
        Schema::dropIfExists('free_offers');
    }
};
