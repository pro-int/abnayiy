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
        Schema::table('grades', function (Blueprint $table) {
            $table->foreignId('created_by')->after('active')->nullable()->references('id')->on('users')->nullOnDelete();
            $table->foreignId('updated_by')->after('active')->nullable()->references('id')->on('users')->nullOnDelete();
        });

        Schema::table('levels', function (Blueprint $table) {
            $table->foreignId('created_by')->after('active')->nullable()->references('id')->on('users')->nullOnDelete();
            $table->foreignId('updated_by')->after('active')->nullable()->references('id')->on('users')->nullOnDelete();
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
