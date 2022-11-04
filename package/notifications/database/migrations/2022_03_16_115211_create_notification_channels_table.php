<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationChannelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notification_channels', function (Blueprint $table) {
            $table->id(); //[2,3] only active
            $table->string('channel_name');
            $table->text('config')->nullable();
            $table->string('fuc_name');
            $table->string('icon_name',50)->nullable();
            $table->string('content_name');
            $table->boolean('active')->default(1);
            $table->boolean('is_mandatory')->default(0);
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
        Schema::dropIfExists('notification_channels');
    }
}
