<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class testController extends CommonController
{
    public function index($name = "321")
    {
        dd(1);
    }
}
