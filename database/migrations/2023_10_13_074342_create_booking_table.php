<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->bigIncrements('B_id');
            
            $table->unsignedBigInteger('C_id'); // Assuming this is a foreign key to the customer table
            // Define foreign key constraint for C_id
           $table->integer('total')->default(0);

            $table->timestamps();
            $table->foreign('C_id')->references('C_id')->on('customers')->onDelete('cascade')->onUpdate('cascade');
           
          
          
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bookings');
    }
}