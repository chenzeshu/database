<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class User extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user',function (Blueprint $table){
           $table->increments('id');
           $table->string('name')->nullable()->unique();
           $table->string('password');
           $table->string('kittyname')->unique();
           $table->string('email')->nullable();
           $table->string('phone')->nullable();
           //todo 到时候再设default，现在还不明确权限
            $table->string('user_role')->nullable();
            $table->timestamps();
        });

        //todo 还要创建【role】表和【permission】表
//        Schema::create('role',function (Blueprint $table){
//
//        });
//
//        Schema::create('permission',function (Blueprint $table){
//
//        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('user');
//        Schema::drop('role');
//        Schema::drop('permission');
    }
}
