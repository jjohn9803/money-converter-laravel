<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict');
            $table->string('from_acc')->nullable();
            //$table->unsignedBigInteger('from_bank');
            $table->json('from_bank')->nullable();
            //$table->foreign('from_bank')->references('id')->on('banks')->onDelete('cascade');
            $table->string('your_receive_acc')->nullable();
            //$table->unsignedBigInteger('your_receive_bank');
            $table->json('your_receive_bank')->nullable();
            //$table->foreign('your_receive_bank')->references('id')->on('banks')->onDelete('cascade');
            //$table->unsignedBigInteger('to_acc_id');
            $table->json('to_acc_id')->nullable();
            //$table->foreign('to_acc_id')->references('id')->on('bank_accounts')->onDelete('cascade');
            /* $table->unsignedBigInteger('to_bank_id');
            $table->foreign('to_bank_id')->references('id')->on('banks')->onDelete('cascade'); */
            //$table->unsignedBigInteger('from_curr_id');
            $table->json('from_curr_id')->nullable();
            //$table->foreign('from_curr_id')->references('id')->on('currencies')->onDelete('cascade');
            //$table->unsignedBigInteger('to_curr_id');
            $table->json('to_curr_id')->nullable();
            //$table->foreign('to_curr_id')->references('id')->on('currencies')->onDelete('cascade');
            /* $table->unsignedBigInteger('fx_id');
            $table->foreign('fx_id')->references('id')->on('fxes')->onDelete('cascade'); */
            $table->double('fx_rate', 100, 6)->nullable()->default(0.00);
            $table->double('from_amount', 100, 4)->nullable()->default(0.00);
            $table->double('to_amount', 100, 4)->nullable()->default(0.00);
            $table->string('ref_no')->nullable();
            $table->string('receipt_img_path')->nullable();
            $table->string('recipient_receipt_img_path')->nullable();
            $table->smallInteger('status')->default(1); //1=Pending, 2=Confirm Transfer, 3=Cancel Transfer, 4=Accepted, 5=Rejected
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
        Schema::dropIfExists('transactions');
    }
}
