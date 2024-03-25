<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('payment_id')->nullable();
            $table->unsignedTinyInteger('status')->default(0);
            $table->timestamps();
            
            $table->foreign('payment_id', 'fk_payment_transactions_payments1_idx')->references('id')->on('payments');
            $table->foreign('user_id', 'fk_payment_transactions_users1_idx')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment_transactions');
    }
}
