<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoanRepaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loan_repayments', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->bigInteger('loan_id')->unsigned()->nullable();
            $table->decimal('amount_paid', 15, 3)->default(0);
            $table->date('paid_date')->nullable();
            $table->date('weekly_payment_date')->nullable();
            $table->decimal('remaining_balance', 15, 3)->default(0);
            $table->integer('payment_method')->default(0);
            $table->integer('state_id')->default(0);
            $table->text('bank_transaction_details')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('loan_repayments');
    }
}
