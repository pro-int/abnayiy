<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->string('student_name');
            $table->string('birth_place');
            $table->string('national_id');
            $table->date('birth_date');
            $table->boolean('gender');
            $table->boolean('student_care')->default(0);
            $table->boolean('status')->default(0);
            $table->unsignedBigInteger('nationality_id');
            $table->unsignedBigInteger('plan_id');
            $table->unsignedBigInteger('guardian_id');
            $table->unsignedBigInteger('level_id');
            $table->unsignedBigInteger('academic_year_id');
            $table->unsignedBigInteger('appointment_id')->nullable();
            $table->unsignedBigInteger('status_id');
            $table->unsignedBigInteger('transportation_id')->nullable();
            $table->integer('transportation_payment')->nullable();
            $table->unsignedBigInteger('sales_id')->nullable();
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
        Schema::dropIfExists('applications');
    }
}
