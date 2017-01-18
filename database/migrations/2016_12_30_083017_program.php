<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Program extends Migration
{
    /**
     * Run the migrations.
     *  项目管理部
     * @return void
     */
    public function up()
    {
        Schema::create('program',function (Blueprint $table){
            $table->increments('id');
            $table->string('name');   //文件名
            $table->integer('fileid');   //文件大类
            $table->string('filepath');  //文件路径
            $table->string('profession')->nullable();  //行业
            $table->string('area')->nullable();   //区域
            $table->string('PM')->nullable();  //项目经理 project manager
            $table->string('sum')->nullable();  //金额
            $table->string('valid_time')->nullable(); //合同生效时间  用个layer插件
            $table->string('filemanager'); //文件管理员

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
        Schema::drop('program');
    }
}
