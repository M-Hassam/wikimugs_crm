<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePricePlanUrgenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('price_plan_urgencies', function (Blueprint $table) {
            $table->id();
            $table->integer('domain_id')->nullable();
            $table->integer('duration')->nullable();
            $table->string('name')->nullable();
            $table->string('amount')->nullable();
            $table->string('percentage')->nullable();
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
        Schema::dropIfExists('price_plan_urgencies');
    }
}
