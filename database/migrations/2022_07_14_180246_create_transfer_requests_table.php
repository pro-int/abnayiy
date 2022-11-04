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
        Schema::create('transfer_requests', function (Blueprint $table) {
            $table->id();
            $table->double('tuition_fee');
            $table->double('tuition_fee_vat')->default(0);
            $table->double('period_discount')->default(0);
            $table->double('minimum_tuition_fee')->default(0);

            $table->double('bus_fees')->default(0);
            $table->double('bus_fees_vat')->default(0);

            $table->double('total_debt')->default(0);
            $table->double('minimum_debt')->default(0);
            $table->double('dept_paid')->default(0);

            $table->double('total_paid')->default(0);
            $table->date('due_date')->nullable();
            $table->text('payment_ref')->nullable();
            $table->foreignId('contract_id');
            $table->foreignId('next_school_year_id');
            $table->foreignId('next_level_id');
            $table->foreignId('plan_id');
            $table->foreignId('period_id')->nullable();
            $table->foreignId('approved_by_admin')->nullable();
            $table->foreignId('payment_method_id')->nullable();
            $table->foreignId('bank_id')->nullable();
            $table->foreignId('transportation_id')->nullable();
            $table->integer('transportation_payment')->nullable();
            $table->enum('status',['new','pending','complete','NoPayment','expired'])->default('new');
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
        Schema::dropIfExists('transfer_requests');
    }
};
