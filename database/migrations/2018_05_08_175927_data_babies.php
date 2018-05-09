<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DataBabies extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_babies', function (Blueprint $table) 
        {
            $table->bigIncrements('id');
            $table->integer('parent_id')->nullable()->default(null);
            $table->string('title')->nullable();
            $table->string('birthdate')->nullable();
            $table->integer('age')->nullable();
            $table->longtext('description')->nullable();
            $table->string('image')->nullable();
            $table->tinyInteger('status')->default(1);
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
