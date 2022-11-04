<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservedAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reserved_appointments', function (Blueprint $table) {
            $table->id();
            $table->time('appointment_time')->nullable();
            $table->date('date')->nullable();
            $table->boolean('attended')->default(0);
            $table->text('summary')->nullable();
            $table->integer('online')->default(0);
            $table->text('online_url')->nullable();
            $table->unsignedBigInteger('handled_by')->nullable();
            $table->unsignedBigInteger('admin_id')->nullable();
            
            $table->unsignedBigInteger('section_id')->nullable();
            // $table->foreign('section_id')->references('id')->on('appointment_sections')->onDelete('SET NULL');
            
            $table->unsignedBigInteger('office_id')->nullable();
            // $table->foreign('office_id')->references('id')->on('appointment_offices')->onDelete('SET NULL');
            $table->unsignedBigInteger('guardian_id')->nullable();
            // $table->foreign('guardian_id')->references('guardian_id')->on('guardians')->onDelete('SET NULL');
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
        Schema::dropIfExists('reserved_appointments');
    }
}
