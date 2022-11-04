<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('student_name');
            $table->string('student_name_en');
            $table->date('birth_date');
            $table->boolean('gender');
            $table->bigInteger('national_id');
            $table->string('birth_place')->nullable();
            $table->boolean('student_care')->default(0);
            $table->unsignedBigInteger('guardian_id');
            $table->unsignedBigInteger('nationality_id');
            $table->unsignedBigInteger('level_id');
            $table->unsignedBigInteger('plan_id');
            $table->timestamp('last_noor_sync')->nullable();
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
        Schema::dropIfExists('students');
    }
}
