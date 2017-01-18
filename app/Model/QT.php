<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class QT extends Model
{
    protected $table = 'quality';
    protected $primaryKey = 'id';
    public $timestamps = true;
    public $guarded = [];
}
