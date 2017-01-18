<?php

namespace App\Http\Controllers\Approve;

use App\Http\Controllers\Admin\CommonController;
use App\Model\user;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class UserController extends CommonController
{
    public function index()
    {
        $data = user::paginate(15);
        session(['filetype'=>'用户管理']);
        return view('approve.user.index',compact('data'));
    }

    public function edit($id)
    {
        $data = user::find($id);
        return view('approve.user.edit',compact('data'));
    }

    public function update($id)
    {
        $input = Input::except('_token','_method');
        $rules = [
            'name'=>'required',
            'email'=>'required',
            'phone'=>'required',
            'kittyname'=>'required',
        ];

        $message = [
            'name.required' =>'[姓名]必须填写',
            'email.required' =>'[邮箱]必须填写',
            'phone.required' =>'[手机号码]必须填写',
            'kittyname.required' =>'[真实姓名]必须填写',
        ];
        $validator = Validator::make($input,$rules,$message);
        if ($validator->passes()){

            $re = user::where('id',$id)->update($input);

            if($re) {
                return redirect('approve/user/');
            }else{
                return back()->with('errors','上传有误，请稍后重试！');
            }

        }else{
            return back()->withErrors($validator);
        }
    }

    public function destroy($id)
    {
        $re = IP::where('id',$id)->delete();
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
