<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDailyFunnelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('daily_funnels', function (Blueprint $table) {
            $table->bigIncrements('idDailyFunnels');
            $table->integer('funnel_id');
            $table->string('merchant_id');
            $table->date('analytics_date');
            $table->float('sales_total');
            $table->integer('conversions_total');
            $table->float('postpurchase_revenue_total');
            $table->integer('visits_total');
            $table->string('ident');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('daily_funnels');
    }
}
