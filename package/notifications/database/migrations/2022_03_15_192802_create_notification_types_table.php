<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notification_types', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('notification_id');
            $table->enum('target_user',['admin','user']);
            $table->unsignedBigInteger('content_id')->nullable();
            $table->enum('frequent',['single','frequent'])->default('single');
            $table->enum('type',['internal','external']);
            $table->string('channels')->nullable(); //[1,2,3]
            $table->string('to_notify')->nullable();
            $table->boolean('active')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notification_types');
    }
}
