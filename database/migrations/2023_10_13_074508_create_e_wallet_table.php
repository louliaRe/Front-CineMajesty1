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
        Schema::create('_e_wallets', function (Blueprint $table) {
            $table->bigIncrements('EW_id');
            $table->unsignedBigInteger('C_id');  
            $table->integer('amount');
            $table->string('address');
            $table->string('PIN');
            
            $table->timestamps();

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
        Schema::dropIfExists('_e_wallets');
    }
};
