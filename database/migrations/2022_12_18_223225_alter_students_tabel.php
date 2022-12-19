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
        Schema::table('students', function (Blueprint $table) {
            $table->integer('odd_record_id')->nullable()->after('last_noor_sync');
            $table->boolean('odoo_sync_status')->default(0)->after('last_noor_sync');
            $table->string('odoo_message')->nullable()->after('last_noor_sync');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn('odd_record_id');
            $table->dropColumn('odoo_sync_status');
            $table->dropColumn('odoo_message');
        });
    }
};
