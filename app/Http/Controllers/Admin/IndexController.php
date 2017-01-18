<?php

namespace App\Http\Controllers\Admin;

use App\Model\Approve;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;



class IndexController extends CommonController
{
    public function index()
    {
        $data = Approve::where('approveman',session('user_kittyname'))->where('status',0)->get();
        $num = count($data);
        return view('index',compact('num'));
    }
}
