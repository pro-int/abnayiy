<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationContentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notification_contents', function (Blueprint $table) {
            $table->id();
            $table->string('content_name');
            $table->text('internal_content')->nullable();
            $table->text('sms_content')->nullable();
            $table->text('email_content')->nullable();
            $table->text('telegram_content')->nullable();
            $table->text('whatsapp_content')->nullable();
            $table->text('content_vars')->nullable();
            
            $table->unsignedBigInteger('event_id');
            // $table->foreign('event_id')->references('id')->on('notification_events')->onDelete('SET NULL');
            
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
        Schema::dropIfExists('notification_contents');
    }
}
