<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ForeignKeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // //admins 
        // Schema::table('admins', function (Blueprint $table) {
        //     $table->foreign('admin_id')
        //         ->references('id')
        //         ->on('users')
        //         ->onDelete('cascade')
        //         ->onUpdate('cascade');
        // });

        // //teachers 
        // Schema::table('teachers', function (Blueprint $table) {
        //     $table->foreign('teacher_id')
        //         ->references('id')
        //         ->on('users')
        //         ->onDelete('cascade')
        //         ->onUpdate('cascade');
        // });

        // //guardians 
        // Schema::table('guardians', function (Blueprint $table) {
        //     $table->foreign('guardian_id')
        //         ->references('id')
        //         ->on('users')
        //         ->onDelete('cascade')
        //         ->onUpdate('cascade');

        //         $table->foreign('nationality_id')
        //         ->references('id')
        //         ->on('nationalities')
        //         ->onDelete('cascade')
        //         ->onUpdate('cascade');
                
        // });

        // //grades
        // Schema::table('grades', function (Blueprint $table) {
        //     $table->foreign('gender_id')
        //         ->references('id')
        //         ->on('genders')
        //         ->onDelete('cascade')
        //         ->onUpdate('cascade');
        // });

        // // levels
        // Schema::table('levels', function (Blueprint $table) {
        //     $table->foreign('grade_id')
        //         ->references('id')
        //         ->on('grades')
        //         ->onDelete('cascade')
        //         ->onUpdate('cascade');
        // });

        // //class_rooms
        // Schema::table('class_rooms', function (Blueprint $table) {
        //     $table->foreign('level_id')
        //         ->references('id')
        //         ->on('levels')
        //         ->onDelete('cascade')
        //         ->onUpdate('cascade');
        // });


        // //students
        // Schema::table('students', function (Blueprint $table) {
        //     $table->foreign('class_id')
        //         ->references('id')
        //         ->on('class_rooms')
        //         ->onDelete('cascade')
        //         ->onUpdate('cascade');

        //     $table->foreign('guardian_id')
        //         ->references('guardian_id')
        //         ->on('guardians')
        //         ->onDelete('cascade')
        //         ->onUpdate('cascade');
        // });

        // //teaches
        // Schema::table('teaches', function (Blueprint $table) {
        //     $table->foreign('teacher_id')
        //         ->references('teacher_id')
        //         ->on('teachers')
        //         ->onDelete('cascade')
        //         ->onUpdate('cascade');

        //     $table->foreign('subject_id')
        //         ->references('id')
        //         ->on('subjects')
        //         ->onDelete('cascade')
        //         ->onUpdate('cascade');

        //     $table->foreign('class_id')
        //         ->references('id')
        //         ->on('class_rooms')
        //         ->onDelete('cascade')
        //         ->onUpdate('cascade');
        // });

        // // genders
        // Schema::table('genders', function (Blueprint $table) {
        //     $table->foreign('type_id')
        //         ->references('id')
        //         ->on('types')
        //         ->onDelete('cascade')
        //         ->onUpdate('cascade');
        // });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
