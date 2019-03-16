<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddExpRangeToSitters extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('data_sitter_details', function (Blueprint $table) 
        {
            $table->integer('age_start_range')->after('hourly_rate')->default(0)->nullable();
            $table->integer('age_end_range')->after('age_start_range')->default(100)->nullable();
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
