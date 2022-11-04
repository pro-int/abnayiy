<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('application_id')->nullable();
            $table->unsignedBigInteger('academic_year_id');
            $table->unsignedBigInteger('plan_id');
            $table->unsignedBigInteger('level_id');
            $table->unsignedBigInteger('admin_id');
            $table->string('applied_semesters');
            $table->double('tuition_fees');
            $table->integer('vat_rate')->default(0);
            $table->double('vat_amount')->default(0);
            $table->double('period_discounts')->default(0);
            $table->double('coupon_discounts')->default(0);
            $table->double('discounts')->default(0);
            $table->double('total_fees');
            $table->double('bus_fees')->default(0);
            $table->double('total_paid')->default(0);
            $table->unsignedBigInteger('terms_id')->nullable();
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
        Schema::dropIfExists('contracts');
    }
}
