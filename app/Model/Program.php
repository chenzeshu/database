<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    protected $table = 'program';
    protected $primaryKey = 'id';
    public $timestamps = true;
    public $guarded = [];
}
