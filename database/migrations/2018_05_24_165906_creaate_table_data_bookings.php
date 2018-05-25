<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreaateTableDataBookings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_bookings', function (Blueprint $table) 
        {
            $table->bigIncrements('id');
            $table->integer('user_id')->nullable()->default(null);
            $table->integer('sitter_id')->nullable()->default(null);
            $table->integer('baby_id')->nullable()->default(null);
            $table->string('baby_ids')->nullable()->default(null);
            $table->integer('is_multiple')->nullable()->default(0);
            $table->date('booking_date')->nullable();
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->datetime('booking_start_time')->nullable();
            $table->datetime('booking_end_time')->nullable();
            $table->string('booking_status')->nullable()->default(null);
            $table->integer('status')->nullable()->default(0);
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
