<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Qualitytest extends Migration
{
    /**
     * Run the migrations.
     * QT质检表
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quality',function (Blueprint $table){
            $table->increments('id');
            $table->string('name');  //产品名称
            $table->string('fileid')->nullable(); //文档大类
            $table->string('filepath')->nullable(); //路径
            $table->string('filemanager')->nullable();  //管理维护员
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
        Schema::drop('quality');
    }
}
