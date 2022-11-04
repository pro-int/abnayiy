<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentAttemptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_attempts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('transaction_id');
            $table->unsignedBigInteger('payment_method_id');
            $table->double('requested_ammount');
            $table->double('received_ammount')->default(0);
            $table->boolean('approved')->default(0);
            $table->string('reference')->nullable();
            $table->string('attach_pathh')->nullable();
            $table->string('reason')->nullable();
            $table->string('coupon')->nullable();
            $table->double('coupon_discount')->default(0);
            $table->double('period_discount')->default(0);
            $table->unsignedBigInteger('guardian_id')->nullable();
            $table->unsignedBigInteger('period_id')->nullable();
            $table->unsignedBigInteger('bank_id')->nullable();
            $table->unsignedBigInteger('admin_id')->nullable();
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
        Schema::dropIfExists('payment_attempts');
    }
}
