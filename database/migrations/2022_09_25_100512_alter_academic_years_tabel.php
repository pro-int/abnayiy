<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
            // $table->unsignedBigInteger('previous_year_id')->nullable()->after('min_debt_percent');
            $table->date('installments_available_until')->default(now())->after('min_debt_percent');
            $table->date('last_installment_date')->default(now())->after('min_debt_percent');

        });
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
};
