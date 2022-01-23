<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->decimal('loan_amount_required',15,3)->default(0);
            $table->decimal('user_monthly_earnings',15,3)->default(0);
            $table->integer('loan_term')->default(0);
            $table->integer('state_id')->default(0); 
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->date('amount_sactioned_date')->nullable();
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
        Schema::dropIfExists('loans');
    }
}
