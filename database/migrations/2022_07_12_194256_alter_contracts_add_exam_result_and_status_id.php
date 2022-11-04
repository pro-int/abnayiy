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
            $table->boolean('status')->default(0)->after('admin_id');
            $table->enum('exam_result',['pass','fail'])->nullable()->default(null)->after('admin_id');
            $table->double('debt')->default(0)->after('bus_fees');
            // $table->unsignedBigInteger('application_id')->nullable();
            $table->foreignId('class_id')->nullable()->after('admin_id');
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
            $table->dropColumn('status_id');
            $table->dropColumn('exam_result');
            $table->dropColumn('debt');
            $table->dropColumn('class_id');
        });
    }
};
