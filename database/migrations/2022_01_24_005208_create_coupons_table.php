<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code', 20);
            $table->double('coupon_value');
            $table->double('used_value')->default(0);
            $table->timestamp('available_at')->useCurrent();
            $table->timestamp('expire_at')->nullable();
            $table->unsignedBigInteger('level_id');
            $table->unsignedBigInteger('academic_year_id');
            $table->boolean('used_coupon')->default(0);
            $table->unsignedBigInteger('add_by');
            $table->boolean('active');
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
        Schema::dropIfExists('coupons');
    }
}
