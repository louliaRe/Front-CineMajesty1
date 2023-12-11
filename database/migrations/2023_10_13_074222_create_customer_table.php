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
        Schema::create('customers', function (Blueprint $table) {
            $table->bigIncrements('C_id');
            $table->unsignedBigInteger('R_id')->default(4);
            $table->string('f_name');
            $table->string('l_name');
            $table->string('email')->unique();
            $table->string('password');
            $table->integer('age');
            $table->string('gender');
            $table->integer('rate')->nullable();
            $table->integer('tickets_num')->default(0);
          
            $table->timestamps();
            
            // Define the foreign key constraint
            $table->foreign('R_id')
                  ->references('r_id') // Match the column name in the role table
                  ->on('roles')
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
        Schema::dropIfExists('customers');
    }
};
