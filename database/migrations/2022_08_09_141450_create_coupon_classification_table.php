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
        Schema::create('coupon_classifications', function (Blueprint $table) {
            $table->id();
            $table->string('classification_name');
            $table->string('classification_prefix');
            $table->integer('limit');
            $table->integer('used_limit')->default(0);
            $table->integer('unused_limit')->default(0);
            $table->string('color_class');
            $table->unsignedBigInteger('academic_year_id');
            $table->unsignedBigInteger('admin_id');
            $table->boolean('active')->default(0);
            $table->softDeletes();
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
        Schema::dropIfExists('coupon_classifications');
    }
};
