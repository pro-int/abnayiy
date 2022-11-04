<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentTransportationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_transportations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id')->nullable();
            $table->unsignedBigInteger('transportation_id');
            $table->unsignedBigInteger('payment_type');
            $table->unsignedBigInteger('contract_id');
            $table->text('address')->nullable();
            $table->double('base_fees');
            $table->double('vat_amount')->default(0);
            $table->double('total_fees');
            $table->date('expire_at');
            $table->unsignedBigInteger('add_by');
            $table->unsignedBigInteger('transaction_id');
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
        Schema::dropIfExists('student_transportations');
    }
}
