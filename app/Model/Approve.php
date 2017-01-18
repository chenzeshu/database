<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class Approve extends Model
{
    protected $table = 'approve';
    protected $primaryKey = 'id';
    public $timestamps = true;
    public $guarded = [];

    static function createStaticTable($tablename){
        //todo 先判断存不存在表
        $exist = Schema::hasTable($tablename);
        if (!$exist){
            DB::statement('CREATE TABLE zw_da_'.$tablename.' AS (SELECT * FROM zw_da_admin_subtable)');
        }
        return 1;
    }
}
