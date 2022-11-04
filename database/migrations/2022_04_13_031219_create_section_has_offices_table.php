<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSectionHasOfficesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('section_has_offices', function (Blueprint $table) {
            $table->unsignedBigInteger('appointment_section_id')->nullable();
            $table->foreign('appointment_section_id')->references('id')->on('appointment_sections')->onDelete('SET NULL');
            $table->unsignedBigInteger('appointment_office_id')->nullable();
            $table->foreign('appointment_office_id')->references('id')->on('appointment_offices')->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('section_has_offices');
    }
}
