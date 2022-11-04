<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGradesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grades', function (Blueprint $table) {
            $table->id();
            $table->string('grade_name');
            $table->string('grade_name_noor')->nullable();
            $table->string('grade_code')->nullable();
            $table->integer('active')->default(1);
            $table->unsignedBigInteger('appointment_section_id');
            $table->unsignedBigInteger('noor_account_id');
            $table->unsignedBigInteger('gender_id');
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
        Schema::dropIfExists('grades');
    }
}
