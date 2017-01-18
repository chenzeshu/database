<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class JC extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /**行业表
         *  2个字段：id与行业,用样有CRUD
         */
        Schema::create('jc_profession',function (Blueprint $table){
           $table->increments('id');
           $table->string('profession')->unique();
           $table->timestamps();
        });
        /**文件表
         *
         */
        Schema::create('jc',function (Blueprint $table){
            $table->increments('id');
            $table->string('name');  //方案名称
            $table->string('professionid'); //方案行业分类  =>与jc_profession中的id对应
            $table->string('fileid'); //方案属性分类
            $table->string('cartype')->nullable(); //车型
            $table->string('area')->nullable(); //区域: 三级制
            $table->string('filepath')->nullable(); //证书文件路径
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
        Schema::drop('jc_profession');
        Schema::drop('jc');
    }
}
