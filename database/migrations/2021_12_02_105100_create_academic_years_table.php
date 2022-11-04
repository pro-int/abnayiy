<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAcademicYearsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('academic_years', function (Blueprint $table) {
            $table->id();
            $table->string('year_name');
            $table->integer('year_numeric');
            $table->date('year_start_date');
            $table->date('year_end_date');
            $table->date('start_transition');
            $table->integer('year_hijri');
            $table->boolean('current_academic_year')->default(0);
            $table->boolean('is_open_for_admission')->default(0);
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
        Schema::dropIfExists('academic_years');
    }
}
