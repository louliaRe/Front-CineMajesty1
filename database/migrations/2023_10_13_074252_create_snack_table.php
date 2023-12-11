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
        Schema::create('snacks', function (Blueprint $table) {
            $table->bigIncrements('S_id');
            $table->string('name');
            $table->unsignedBigInteger('CAT_id');     
            $table->integer('price');
            $table->integer('qty');
            $table->integer('limit');
            $table->foreign('CAT_id')
            ->references('CAT_id') 
            ->on('categories')
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
        Schema::dropIfExists('snacks');
    }
};
