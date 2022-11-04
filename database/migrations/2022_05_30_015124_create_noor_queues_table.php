<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * fdsa
     * @return void
     */
    public function up()
    {
        Schema::create('noor_queues', function (Blueprint $table) {
            $table->id();
            $table->string('job_name')->nullable();
            $table->integer('job_type');
            $table->unsignedBigInteger('class_id')->nullable();
            $table->unsignedBigInteger('grade_id')->nullable();
            $table->enum('job_status',['new','in progress', 'done','fail'])->default('new');
            $table->text('job_result')->nullable();
            $table->text('file_path')->nullable();
            $table->unsignedBigInteger('noor_account_id');

            $table->timestamps();
            // $table->foreign('noor_account_id')->references('id')->on('noor_accounts')->onDelete('SET NULL');
            // $table->foreign('class_id')->references('id')->on('class_rooms')->onDelete('SET NULL');
            // $table->foreign('grade_id')->references('id')->on('grades')->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('noor_queues');
    }
};
