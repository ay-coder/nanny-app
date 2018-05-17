<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableDataMessages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_messags', function (Blueprint $table) 
        {
            $table->bigIncrements('id');
            $table->integer('from_user_id')->nullable()->default(null);
            $table->integer('to_user_id')->nullable()->default(null);
            $table->string('image')->nullable()->default(null);
            $table->longtext('message')->nullable();
            $table->integer('is_image')->nullable()->default(0);
            $table->integer('is_read')->nullable()->default(0);
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
