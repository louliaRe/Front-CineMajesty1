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
        Schema::create('private_offers', function (Blueprint $table) {
            $table->bigIncrements('PR_id');
            
        
            $table->unsignedBigInteger('C_id');
            $table->boolean('is_used');
            $table->timestamp('start_date');
            $table->date('expire_date');
            $table->integer('amount');
            $table->string('code')->unique();
            $table->timestamps();

            
              // Define the foreign key constraint
         
              
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
        Schema::dropIfExists('private_offers');
    }
};
