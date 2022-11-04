<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOfficeSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('office_schedules', function (Blueprint $table) {
            $table->id();
            $table->enum('day_of_week', [0,1,2,3,4,5,6]);
            $table->time('time_from')->nullable();
            $table->time('time_to')->nullable();
            $table->unsignedBigInteger('office_id')->nullable();
            // $table->foreign('office_id')->references('id')->on('offices')->onDelete('SET NULL');
            $table->boolean('active')->default(0);
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
        Schema::dropIfExists('office_schedules');
    }
}
