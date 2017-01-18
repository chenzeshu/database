<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class IP extends Model
{
    protected $table = 'ip';
    protected $primaryKey = 'id';
    public $timestamps = true;
    public $guarded = [];
}
