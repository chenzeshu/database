<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Approve extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /**
         * 审核状态 0 审批中
         *          1 审批通过
         *           2 审批未通过
         */
        Schema::create('approve',function (Blueprint $table){
            $table->increments('id');
            $table->string('name')->default('审批表'); //显式名字
            $table->string('watermark');  //用途or水印
            $table->string('person');     //申请人
            $table->string('approveman'); //审核人
            $table->string('status');     //审核状态
            $table->string('tablename');  //提交表的数据库表名
            $table->string('tips')->nullable(); //审核语
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
        Schema::drop('approve');
    }
}
