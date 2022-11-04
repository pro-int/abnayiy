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
            $table->unsignedBigInteger('contract_id');
            $table->unsignedBigInteger('period_id')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('payment_getaway')->nullable();
            $table->string('installment_name');
            $table->double('amount_before_discount');
            $table->double('vat_amount')->default(0);
            $table->integer('discount_rate')->default(0);
            $table->double('period_discount')->default(0);
            $table->string('coupon')->nullable();
            $table->double('coupon_discount')->default(0);
            $table->double('amount_after_discount')->default(0);
            $table->double('paid_amount')->default(0);
            $table->double('residual_amount')->default(0);
            $table->integer('payment_status')->default(0);
            $table->date('payment_due')->nullable();
            $table->date('payment_date')->nullable();
            $table->unsignedBigInteger('admin_id')->nullable();
            $table->enum('transaction_type',['bus','tuition','debt'])->default('tuition');
            $table->boolean('is_contract_payment')->default(0);
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
