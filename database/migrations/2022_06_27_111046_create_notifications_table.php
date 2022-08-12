<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->BigInteger('transasction_id'); //-1 = not related with transaction, just a normal notification
            $table->string('message_type')->default(6); //1=Pending, 2=Confirm, 3=Cancelled, 4=Accepted, 5=Rejected, 6=Rejected timeout, 7=Errors, 8=Others
            /* $table->string('message')->nullable(); //Append after message_type */
            //$table->foreign('reason_id')->references('id')->on('reason')->onDelete('cascade');
            $table->BigInteger('reason_id');
            $table->smallInteger('status')->default(1); //1=Unread, 2=Read
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
        Schema::dropIfExists('notifications');
    }
}
