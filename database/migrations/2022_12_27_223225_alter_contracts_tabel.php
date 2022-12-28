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
        Schema::table('contracts', function (Blueprint $table) {
            $table->integer('odoo_record_study_id')->nullable()->after('status');
            $table->boolean('odoo_sync_study_status')->default(0)->after('status');
            $table->string('odoo_message_study')->nullable()->after('status');
            $table->renameColumn('odoo_record_id', 'odoo_record_transportation_id');
            $table->renameColumn('odoo_sync_status', 'odoo_sync_transportation_status');
            $table->renameColumn('odoo_message', 'odoo_message_transportation');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contracts', function (Blueprint $table) {
            $table->dropColumn('odoo_record_study_id');
            $table->dropColumn('odoo_sync_study_status');
            $table->dropColumn('odoo_message_study');
        });
    }
};
