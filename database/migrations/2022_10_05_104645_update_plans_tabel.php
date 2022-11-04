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
        Schema::table('plans', function (Blueprint $table) {
            $table->removeColumn('installments');
            $table->enum('plan_based_on',['total','semester','selected_date'])->after('fixed_discount');
            $table->integer('payment_due_determination')->default(0)->after('fixed_discount');
            $table->integer('beginning_installment_calculation')->nullable()->after('fixed_discount');
            $table->double('down_payment')->default(0)->after('fixed_discount');
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
