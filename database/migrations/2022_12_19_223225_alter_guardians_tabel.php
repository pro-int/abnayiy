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
        Schema::table('guardians', function (Blueprint $table) {
            $table->integer('odoo_record_id')->nullable()->after('active');
            $table->boolean('odoo_sync_status')->default(0)->after('active');
            $table->string('odoo_message')->nullable()->after('active');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('guardians', function (Blueprint $table) {
            $table->dropColumn('odoo_record_id');
            $table->dropColumn('odoo_sync_status');
            $table->dropColumn('odoo_message');
        });
    }
};
