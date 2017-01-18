<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;

class CommonController extends Controller
{
    //todo warn:即使需要前端多传一个参数，也要把所有upload抽象成一个方法，不然以后不好维护
    /**
     * @param $id 部门
     * @param $
     */
    public function uploadfile($department,$fileid,Request $request,$profession = null)
    {
        $file = $request->file('Filedata');
        if ($file->isValid()){
            $entension = $file ->getClientOriginalExtension(); //文件后缀
            $newName = date('YmdHis').mt_rand(100,999).'.'.$entension;
            /**
             * @param $department IP:知识产权，JC：集成规划所，PR：人事部，PRO：项目管理部，QT：质检
             * @param $filetype 分属的文件种类，详见routes/web.php
             * @param $profession 集成规划所的行业
             */
            if (!$profession){
                $path = $file->storeAs('public',"{$department}/{$fileid}/".$newName);
                $path = str_replace('public/','storage/',$path);
            }else{
                $path = $file->storeAs('public',"{$department}/{$profession}/{$fileid}/".$newName);
                $path = str_replace('public/','storage/',$path);
            }

            return $path;
        }
    }



    /**
     * 人事部文件上传
     * 先实现部门分类
     * 最后看需求再细化部门下分类
     * 不然一个文件夹几千个文件，实际维护时也很卡
     */
    public function upload()
    {
        $file = Input::file('Filedata');
        if ($file->isValid()){
            $entension = $file ->getClientOriginalExtension(); //文件后缀
            $newName = date('YmdHis').mt_rand(100,999).'.'.$entension;
            $path = $file ->move(base_path().'/uploads/PR',$newName);
            $filepath = 'uploads/PR/'.$newName;
            return $filepath;
        }
    }

    /**
     * 项目管理部文件上传
     * 最后看需求再细化部门下分类
     */
    public function upload1()
    {
        $file = Input::file('Filedata');
        if ($file->isValid()){
            $entension = $file ->getClientOriginalExtension(); //文件后缀
            $newName = date('YmdHis').mt_rand(100,999).'.'.$entension;
            $path = $file ->move(base_path().'/uploads/PRO',$newName);
            $filepath = 'uploads/PRO/'.$newName;
            return $filepath;
        }
    }
    /**
     * 质检部文件上传
     * 最后看需求再细化部门下分类
     */
    public function upload2()
    {
        $file = Input::file('Filedata');
        if ($file->isValid()){
            $entension = $file ->getClientOriginalExtension(); //文件后缀
            $newName = date('YmdHis').mt_rand(100,999).'.'.$entension;
            $path = $file ->move(base_path().'/uploads/QT',$newName);
            $filepath = 'uploads/QT/'.$newName;
            return $filepath;
        }
    }
    /**
     * 知识产权文件上传
     * 最后看需求再细化部门下分类
     */
    public function upload3(Request $request)
    {
        $file = $request->file('Filedata');
        if ($file->isValid()){
            $entension = $file ->getClientOriginalExtension(); //文件后缀
            $newName = date('YmdHis').mt_rand(100,999).'.'.$entension;
//            $path = $file ->move(base_path().'/uploads/IP',$newName);
            $path = $file->storeAs('public','IP/'.$newName);
            $path = str_replace('public/','storage/',$path);
//            $filepath = 'IP/'.$newName;
            return $path;
//            $filepath = 'uploads/IP/'.$newName;
        }
    }

    /**
     * 集成规划所文件上传
     * 最后看需求再细化部门下分类
     */
    public function upload4()
    {
        $file = Input::file('Filedata');
        if ($file->isValid()){
            $entension = $file ->getClientOriginalExtension(); //文件后缀
            $newName = date('YmdHis').mt_rand(100,999).'.'.$entension;
            $path = $file ->move(base_path().'/uploads/JC',$newName);
            $filepath = 'uploads/JC/'.$newName;
            return $filepath;
        }
    }

    
}
