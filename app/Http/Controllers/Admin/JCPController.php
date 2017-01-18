<?php

namespace App\Http\Controllers\Admin;

use App\Model\JC_PROFESSION;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class JCPController extends Controller
{
    public function index()
    {
        $data = JC_PROFESSION::orderBy('id')->paginate(10);
        session(['filetype'=>'行业']);
        return view('admin.JCP.index',compact('data'));
    }

    public function create()
    {
        return view('admin.JCP.create');
    }

    public function store()
    {
        $input = Input::except('_token');
        $rules = [
            'profession'=>'required',
        ];

        $message = [
            'profession.required' =>'[行业名]必须填写',
        ];
        $validator = Validator::make($input,$rules,$message);
        if ($validator->passes()){

            $re = JC_PROFESSION::create($input);

            if($re) {
                return redirect('admin/JCP/');
            }else{
                return back()->with('errors','上传有误，请稍后重试！');
            }

        }else{
            return back()->withErrors($validator);
        }
    }

    public function edit($id)
    {
        $data = JC_PROFESSION::find($id);
        return view('admin.JCP.edit',compact('data'));
    }

    public function update($id)
    {
        $input = Input::except('_token','_method');
        $rules = [
            'profession'=>'required',
        ];

        $message = [
            'profession.required' =>'[行业名]必须填写',
        ];
        $validator = Validator::make($input,$rules,$message);
        if ($validator->passes()){

            $re = JC_PROFESSION::where('id',$id)->update($input);

            if($re) {
                return redirect('admin/JCP/');
            }else{
                return back()->with('errors','上传有误，请稍后重试！');
            }

        }else{
            return back()->withErrors($validator);
        }
    }

    public function destroy($id)
    {
        $re = JC_PROFESSION::where('id',$id)->delete();
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
}
