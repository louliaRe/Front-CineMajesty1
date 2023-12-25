<?php 
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSnackBuyingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('book_Snack', function (Blueprint $table) {
            $table->bigIncrements('SB_id');
            $table->unsignedBigInteger('S_id'); // Assuming this is a foreign key to the snack table
            $table->unsignedBigInteger('B_id'); // Assuming this is a foreign key to the booking table
            $table->integer('Qty')->nullable();
            
            
            // Define foreign key constraints for S_id and B_id
            $table->foreign('S_id')->references('S_id')->on('snacks')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('B_id')->references('B_id')->on('bookings')->onDelete('cascade')->onUpdate('cascade');
            
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
        Schema::dropIfExists('book_Snack');
    }
}
