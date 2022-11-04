<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notification_events', function (Blueprint $table) {
            $table->id();
            $table->string('event_name'); 
            $table->unsignedBigInteger('section_id');
            $table->string('model_namespace');
            $table->boolean('single_allowed')->default(0);
            $table->boolean('frequent_allowed')->default(0);
            $table->boolean('internal_allowed')->default(0);
            $table->boolean('external_allowed')->default(0);
            // $table->foreign('section_id')->references('id')->on('notification_sections')->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notification_events');
    }
}
