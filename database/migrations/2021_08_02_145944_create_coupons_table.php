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
            $table->integer('coupon_type_id');
            $table->integer('domain_id')->nullable();
            $table->string('per_user')->nullable();
            $table->string('limit')->nullable();
            $table->string('code');
            $table->string('discount');
            $table->string('start_date');
            $table->string('end_date');
            $table->text('description')->nullable();
            $table->integer('status')->default(0);
            $table->string('created_by')->nullable();
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
        Schema::dropIfExists('coupons');
    }
}
