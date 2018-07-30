<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPaymentDetailsToSubscription extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('data_user_active_plans', function (Blueprint $table) 
        {
            $table->integer('payment_status')->nullable()->default(null);
            $table->longtext('payment_via')->nullable()->default(null);
            $table->longtext('payment_details')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
