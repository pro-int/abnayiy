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
        Schema::table('transportations', function (Blueprint $table) {
            $table->string('odoo_product_id')->nullable()->after('monthly_fees');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transportations', function (Blueprint $table) {
            $table->dropColumn('odoo_product_id');
        });
    }
};
