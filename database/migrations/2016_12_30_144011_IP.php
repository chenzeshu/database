<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class IP extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ip',function (Blueprint $table){
            $table->increments('id');
            $table->string('name');  //证书名称
            $table->string('number'); //专利号/专利申请号/商标号
            $table->string('fileid')->nullable(); //证书大类
            $table->string('filepath')->nullable(); //证书文件路径
            $table->string('filemanager')->nullable();  //管理维护员
            $table->timestamps();
            /**
             * 荣誉证书特属
             */
            $table->string('relation')->nullable(); //相关产品
            $table->string('issue_unit')->nullable(); //发放单位
            $table->string('issue_time')->nullable(); //发放时间
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('ip');
    }
}
