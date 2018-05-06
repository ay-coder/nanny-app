<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) 
        {
            $table->string('profile_pic')->after('remember_token')->default('default.png')->nullable();
            $table->string('device_token')->after('profile_pic')->nullable();
            $table->string('device_type')->after('device_token')->nullable();
            $table->string('user_type')->after('device_type')->nullable();
            $table->string('gender')->after('user_type')->nullable();
            $table->string('birthdate')->after('gender')->nullable();
            $table->string('address')->after('birthdate')->nullable();
            $table->string('city')->after('address')->nullable();
            $table->string('state')->after('city')->nullable();
            $table->string('zip')->after('state')->nullable();
            $table->string('lat')->after('zip')->nullable();
            $table->string('long')->after('lat')->nullable();
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
