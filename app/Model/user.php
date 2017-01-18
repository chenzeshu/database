<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class user extends Model
{
    protected $table ='user';
    protected $primaryKey = 'id';
    public $timestamps = 'true';
    protected $guarded =[];

    static function createAndShowSubTable($table_name)
    {
        //todo 先判断存不存在表
        $exist = Schema::hasTable($table_name);
        if (!$exist) {
            //todo 建表
            Schema::create($table_name, function (Blueprint $table) {
                $table->increments('id');
                $table->string('filename');
                $table->string('filepath');
                $table->string('filehome'); //文件归属于
                $table->integer('times')->nullable(); //下载次数
                $table->timestamp('created_at')->default(\DB::raw('CURRENT_TIMESTAMP'));
                $table->timestamp('updated_at')->default(\DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
            });
        }

        //tips:提交后生成的表是直接复制的本表结构与数据，逻辑写在Approve/IndexController@submit
    }

    /**
     * @param $kittyname  真实姓名
     * @param $action     行为
     */
    static function record($kittyname,$action){

    }
}
