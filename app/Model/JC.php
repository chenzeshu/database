<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class JC extends Model
{
    protected $table = 'jc';
    protected $primaryKey = 'id';
    public $timestamps = true;
    public $guarded = [];
}
