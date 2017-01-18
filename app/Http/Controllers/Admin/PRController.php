<?php

namespace App\Http\Controllers\Admin;

use App\Model\Personal;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\In;

/*
 * #file_desc:Personal-Record Controller
 */

class PRController extends CommonController
{
    public function index($fileid)
    {
        switch ($fileid){
            case "1";
                //个人证件照
                $data = Personal::where('fileid',1)->paginate(10);
                session(['fileid'=>1,'filetype' => '个人证件照']);
                return view('admin/PersonalRecord/index',compact('data'));
                break;
            case "2";
                //身份证
                $data = Personal::where('fileid',2)->paginate(10);
                session(['fileid'=>2,'filetype' => '身份证']);
                return view('admin/PersonalRecord/index',compact('data'));
                break;
            case "3";
                //学历学位
                $data = Personal::where('fileid',3)->paginate(10);
                session(['fileid'=>3,'filetype' => '学历学位']);
                return view('admin/PersonalRecord/index',compact('data'));
                break;
            case "4";
                //职称证书
                $data = Personal::where('fileid',4)->paginate(10);
                session(['fileid'=>4,'filetype' => '职称证书']);
                return view('admin/PersonalRecord/index',compact('data'));
                break;
            case "5";
                //培训证书
                $data = Personal::where('fileid',5)->paginate(10);
                session(['fileid'=>5,'filetype' => '培训证书']);
                return view('admin/PersonalRecord/index',compact('data'));
                break;
        }
    }

    public function create()
    {
        /*
         * 添加
         * @typeid int 文件类型
         */
        return view('admin/PersonalRecord/create');
    }
    public function store()
    {
        $input = Input::except('_token');
        $rules = [
            'name'=>'required',
            'fileid'=>'required',
            'filepath'=>'required',
        ];

        $message = [
            'name.required' =>'[姓名]必须填写',
            'fileid.required' =>'[文件类型]必须选择',
            'filepath.required' =>'[文件路径]必须存在',
        ];
        $validator = Validator::make($input,$rules,$message);
        if ($validator->passes()){

            $re = Personal::create($input);

                if($re) {
                    return redirect('admin/PR/index/'.session('fileid'));
                }else{
                    return back()->with('errors','上传有误，请稍后重试！');
                }

        }else{
            return back()->withErrors($validator);
        }
    }

    public function edit($id)
    {
        $data = Personal::find($id);
        return view('admin.PersonalRecord.edit',compact('data'));
    }

    public function update($id)
    {
        $input = Input::except('_token','_method');
        $rules = [
            'name'=>'required',
            'fileid'=>'required',
            'filepath'=>'required',
        ];

        $message = [
            'name.required' =>'[姓名]必须填写',
            'fileid.required' =>'[文件类型]必须选择',
            'filepath.required' =>'[文件路径]必须存在',
        ];
        $validator = Validator::make($input,$rules,$message);
        if ($validator->passes()){

            $re = Personal::where('id',$id)->update($input);

            if($re) {
                return redirect('admin/PR/index/'.session('fileid'));
            }else{
                return back()->with('errors','上传有误，请稍后重试！');
            }

        }else{
            return back()->withErrors($validator);
        }
    }

    public function destroy($id)
    {
        $re = Personal::where('id',$id)->delete();
        if($re){
            $data = [
                'status'=> 0,   //因为是ajax异步返回，所以返回一个json数据
                'msg' => '删除成功',
            ];
        }else{
            $data = [
                'status'=> 1,   //因为是ajax异步返回，所以返回一个json数据
                'msg' => '删除失败，请稍后重试',
            ];
        }
        return $data;
    }

    public function search()
    {
        $input = Input::except('_token');
        $data = Personal::where('name','like',"%".$input['name']."%")->where('fileid',session('fileid'))->get();
        return $data;
    }
}
