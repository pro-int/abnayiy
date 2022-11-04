<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_notifications', function (Blueprint $table) {
            $table->id();
            $table->text('notification_text')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('channel_id')->nullable();
            $table->boolean('seen')->default(0);
            $table->boolean('sent')->default(0);
            $table->text('response')->nullable();
            $table->string('internal_url');
            $table->unsignedBigInteger('model_id');
            $table->unsignedBigInteger('notification_type_id');
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
        Schema::dropIfExists('user_notifications');
    }
}
