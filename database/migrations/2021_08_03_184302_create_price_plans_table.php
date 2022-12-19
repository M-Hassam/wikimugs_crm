<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePricePlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('price_plans', function (Blueprint $table) {
            $table->id();
            $table->integer('domain_id')->nullable();
            $table->integer('price_plan_urgency_id')->nullable();
            $table->integer('price_plan_level_id')->nullable();
            $table->integer('price_plan_type_of_work_id')->nullable();
            $table->unique([
                'domain_id',
                'price_plan_urgency_id',
                'price_plan_level_id',
                'price_plan_type_of_work_id'
            ],'unique_priceplan');
            $table->float('price')->nullable();
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
        Schema::dropIfExists('price_plans');
    }
}
