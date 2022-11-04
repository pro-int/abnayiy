<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationFrequentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notification_frequents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('notification_type_id');
            $table->enum('condition_type',['after','before']);
            $table->integer('interval');
            $table->unsignedBigInteger('content_id');
            $table->boolean('active')->default(1);
            $table->timestamps();
          
            // $table->foreign('content_id')->references('id')->on('notification_contents')->onDelete('SET NULL');
            // $table->foreign('notification_type_id')->references('id')->on('notification_types')->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notification_frequents');
    }
}
