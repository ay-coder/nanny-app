<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToSitter extends Migration
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
            $table->integer('hourly_rate')->after('vacation_mode')->default(0);
            $table->string('account_holder_name')->after('description')->nullable();
            $table->string('account_number')->after('account_holder_name')->nullable();
            $table->string('aba_number')->after('account_number')->nullable();
            $table->string('bank_name')->after('aba_number')->nullable();
            $table->longtext('bank_address')->after('bank_name')->nullable();
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
