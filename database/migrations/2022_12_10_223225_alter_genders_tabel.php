<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('genders', function (Blueprint $table) {
            $table->string('grade_name_noor')->nullable();
            $table->unsignedBigInteger('appointment_section_id');
            $table->unsignedBigInteger('noor_account_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('genders', function (Blueprint $table) {
            $table->dropColumn('grade_name_noor');
            $table->dropColumn('appointment_section_id');
            $table->dropColumn('noor_account_id');
        });
    }
};
