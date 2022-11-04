<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentParticipationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_participations', function (Blueprint $table) {
            $table->id();
            $table->integer('home_work')->default(0);
            $table->integer('participation')->default(0);
            $table->integer('attention')->default(0);
            $table->integer('tools')->default(0);
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('subject_id')->default(0);
            $table->unsignedBigInteger('reports_id');
            $table->unsignedBigInteger('add_by');
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
        Schema::dropIfExists('student_participations');
    }
}
