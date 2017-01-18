<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;


/*
 * 人事管理档案
 */
class Personal extends Model
{
    protected $table = "personal";
    protected $primaryKey = 'id';
    public $timestamps = true;
    public $guarded = [];
}
