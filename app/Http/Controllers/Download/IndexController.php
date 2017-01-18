<?php

namespace App\Http\Controllers\Download;

use App\Http\Controllers\Admin\CommonController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;

class IndexController extends CommonController
{
    public function index($url = null)
    {
        //todo 破除百度国人坑B们的无能，造出一个ajax兼容任何浏览器的下载
        if ($url){
            //todo 下载文件
            return Response::download(session('tempdown'),session('tempname').session('extension'));
        }else{
            $input = Input::except('_token');
            $path = $input['path'];
            $name = $input['name'];
            $id = $input['id'];
            $extension = substr($path,strpos($path,'.'));
            session(['tempdown'=>$path,'tempname'=>$name,'extension'=>$extension]);
            //todo 下载次数加1
            DB::table(session('temptable'))->where('id',$id)->increment('times');
            return $id;
        }





    }
}
