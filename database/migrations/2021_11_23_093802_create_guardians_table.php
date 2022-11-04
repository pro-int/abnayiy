<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGuardiansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guardians', function (Blueprint $table) {
            $table->unsignedBigInteger('guardian_id');
            $table->unsignedBigInteger('nationality_id')->nullable();
            $table->unsignedBigInteger('national_id')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->string('city_name')->nullable();
            $table->string('address')->nullable();
            $table->boolean('active')->default(1);
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
        Schema::dropIfExists('guardians');
    }
}
