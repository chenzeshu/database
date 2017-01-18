<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Personal extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /*
         * @table_desc 此表用于存放人事档案所有文件信息
         * fileid =   1            2         3         4          5
         * 对应   =个人证件照     身份证    学历学位   职称证书    培训证书
         */
        Schema::create('personal',function (Blueprint $table){
           $table->increments('id');
           $table->string('name');  //姓名
           $table->string('fileid'); //文件隶属于哪个大类
           $table->string('filemanager');  //文件审核员
           $table->string('filepath');  //文件路径,假如审批通过，后台就放出

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
        Schema::drop('personal');
    }
}
