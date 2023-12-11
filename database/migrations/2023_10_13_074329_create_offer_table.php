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
        Schema::create('public_offers', function (Blueprint $table) {
            $table->bigIncrements('PU_id');
            
      
            $table->timestamp('start_date');
            $table->date('expire_date');
            $table->integer('amount');
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
        Schema::dropIfExists('offers');
    }
};
