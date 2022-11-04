<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLevelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('levels', function (Blueprint $table) {
            $table->id();
            $table->string('level_name');
            $table->string('level_name_noor');
            $table->string('level_code')->nullable();
            $table->integer('tuition_fees');
            $table->double('coupon_discount_persent')->default(0);
            $table->double('period_discount_persent')->default(0);
            $table->integer('min_students')->default(0);
            $table->unsignedBigInteger('grade_id');
            $table->unsignedBigInteger('type_id');
            $table->unsignedBigInteger('gender_id');
            $table->unsignedBigInteger('appointment_section_id');
            $table->integer('active')->default(1);
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
        Schema::dropIfExists('levels');
    }
}
