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
            $table->boolean('odoo_sync_update_invoice_status')->default(0)->after('status');
            $table->string('odoo_message_update_invoice')->nullable()->after('status');
            $table->integer('odoo_record_inverse_journal_id')->nullable()->after('status');
            $table->boolean('odoo_sync_inverse_journal_status')->default(0)->after('status');
            $table->string('odoo_message_inverse_journal')->nullable()->after('status');
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
            $table->dropColumn('odoo_sync_update_invoice_status');
            $table->dropColumn('odoo_message_update_invoice');
            $table->dropColumn('odoo_record_inverse_journal_id');
            $table->dropColumn('odoo_sync_inverse_journal_status');
            $table->dropColumn('odoo_message_inverse_journal');
        });
    }
};
