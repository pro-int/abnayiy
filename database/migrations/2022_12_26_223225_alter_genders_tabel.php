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
            $table->renameColumn('odoo_product_id', 'odoo_product_id_study');
            $table->renameColumn('odoo_account_code', 'odoo_account_code_study');
            $table->string('odoo_product_id_transportation')->nullable()->after('gender_type');
            $table->string('odoo_account_code_transportation')->nullable()->after('gender_type');

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
            $table->dropColumn('odoo_product_id_transportation');
            $table->dropColumn('odoo_account_code_transportation');
        });
    }
};
