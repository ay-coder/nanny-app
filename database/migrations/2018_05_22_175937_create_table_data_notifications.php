<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableDataNotifications extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_notifications', function (Blueprint $table) 
        {
            $table->bigIncrements('id');
            $table->integer('user_id')->nullable()->default(null);
            $table->integer('sitter_id')->nullable()->default(null);
            $table->string('icon')->nullable()->default('default.png');
            $table->longtext('description')->nullable()->default(null);
            $table->integer('status')->nullable()->default(0);
            $table->integer('is_read')->nullable()->default(0);
            $table->datetime('read_time')->nullable();
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
