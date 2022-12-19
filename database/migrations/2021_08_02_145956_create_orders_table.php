<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_new')->default(0);
            $table->integer('domain_id');
            $table->integer('lead_id')->nullable();
            $table->integer('coupon_id')->nullable();
            $table->integer('status_id')->nullable();
            $table->integer('customer_id');
            $table->integer('price_plan_type_of_work_id')->nullable();
            $table->integer('price_plan_level_id')->nullable();
            $table->integer('price_plan_urgency_id')->nullable();
            $table->integer('price_plan_no_of_page_id')->nullable();
            $table->integer('price_plan_indentation_id')->nullable();
            $table->integer('price_plan_subject_id')->nullable();
            $table->integer('price_plan_style_id')->nullable();
            $table->integer('price_plan_language_id')->nullable();
            $table->string('line_spacing')->nullable();
            $table->string('reference')->nullable();
            $table->string('font_style')->nullable();
            $table->string('no_of_pages')->nullable();
            $table->string('order_no')->nullable();
            $table->string('topic')->nullable();
            $table->longText('instructions')->nullable();
            $table->string('customer_sent_date')->nullable();
            $table->string('total_amount')->nullable();
            $table->string('discount_amount')->nullable();
            $table->string('old_discount_amount')->nullable();
            $table->string('manual_discount_amount')->default(0);
            $table->string('addons_amount')->nullable();
            $table->string('service_amount')->nullable();
            $table->string('grand_total_amount')->nullable();
            $table->string('actual_total_amount')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('writer_id')->nullable();
            $table->string('writer_submit_date')->nullable();
            $table->string('writer_deadline')->nullable();
            $table->boolean('is_reassigned')->default(0);
            //$table->integer('price_plan_editing_id')->nullable();
            //$table->integer('price_plan_powerpoint_slide_id')->nullable();
            //$table->integer('price_plan_excel_sheet_graph_id')->nullable();
            //$table->string('subject')->nullable();
            //$table->string('deadline_date')->nullable();
            //$table->string('deadline_time')->nullable();
            //$table->string('plagiarism')->nullable();
            //$table->string('name')->nullable();
            //$table->string('email')->nullable();
            //$table->string('country')->nullable();
            //$table->string('phone_no')->nullable();
            //$table->string('amount')->nullable();
            //$table->string('tax')->nullable();
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
        Schema::dropIfExists('orders');
    }
}
