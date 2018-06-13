<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableSubscriptions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_plans', function (Blueprint $table) 
        {
            $table->bigIncrements('id');
            $table->string('title')->nullable()->default(null);
            $table->float('amount')->nullable()->default(null);
            $table->longtext('description')->nullable()->default(null);
            $table->string('sub_title')->nullable()->default(null);
            $table->string('plan_type')->nullable()->default(null);
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
