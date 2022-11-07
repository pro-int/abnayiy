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
        Schema::create('withdrawal_periods', function (Blueprint $table) {
            $table->id();
            $table->string('period_name');
            $table->date('apply_start');
            $table->date('apply_end');
            $table->unsignedBigInteger('academic_year_id')->nullable();
            $table->enum("fees_type", ['money','percentage']);
            $table->integer("fees");
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
        Schema::dropIfExists('withdrawal_periods');
    }
};
