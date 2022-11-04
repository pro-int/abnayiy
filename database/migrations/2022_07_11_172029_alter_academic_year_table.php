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
        Schema::table('academic_years', function (Blueprint $table) {
            $table->integer('min_debt_percent')->default(0)->after('is_open_for_admission');
            $table->integer('min_tuition_percent')->default(0)->after('is_open_for_admission');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('academic_years', function (Blueprint $table) {
            $table->dropColumn('min_debt_percent');
            $table->dropColumn('min_tuition_percent');
        });
    }
};
