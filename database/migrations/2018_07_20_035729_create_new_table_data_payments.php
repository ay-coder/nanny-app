<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewTableDataPayments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_payments', function (Blueprint $table) 
        {
            $table->bigIncrements('id');
            $table->integer('booking_id')->nullable()->default(null);
            $table->integer('sitter_id')->nullable()->default(null);
            $table->float('per_hour')->nullable()->default(0);
            $table->float('total_hour')->nullable()->default(0);
            $table->float('sub_total')->nullable()->default(0);
            $table->float('tax')->nullable()->default(0);
            $table->float('other_charges')->nullable()->default(0);
            $table->float('parking_fees')->nullable()->default(0);
            $table->float('total')->nullable()->default(0);
            $table->longText('description')->nullable()->default(null);
            $table->string('payment_status')->nullable()->default(null);
            $table->string('payment_via')->nullable()->default(null);
            $table->longText('payment_details')->nullable()->default(null);
            $table->integer('status')->nullable()->default(1);
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
        //
    }
}
