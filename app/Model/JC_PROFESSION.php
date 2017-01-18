<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class JC_PROFESSION extends Model
{
    protected $table = 'jc_profession';
    protected $primaryKey = 'id';
    public $timestamps = true;
    public $guarded = [];
}
