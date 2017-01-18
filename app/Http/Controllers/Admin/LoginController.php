<?php

namespace App\Http\Controllers\Admin;

use App\Model\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Input;

require_once "org/code/Code.class.php";

class LoginController extends CommonController
{
    public function login()
    {
        if ($input = Input::except('_token')){
        //资料区
            //用户名及密码
            $name = $input['user_name'];
            $pass = $input['user_pass'];
            //系统验证码
            $code = new \Code();
            $_code = $code->get();

        //业务区
            //1、验证验证码
            if ($_code == strtoupper($input['code']) ){
                $user = User::where('name',$name)->first();
                if ($user['name'] == $name && Crypt::decrypt($user['password']) == $pass){
                    //保存session
                        session([
                            'user_id'=>$user['id'],
                            'user_name'=>$user['name'],
                            'user_kittyname'=>$user['kittyname'],
                            'tablename'=>$user['name'].'_subtable'
                        ]);
                    //跳转进主页面
                    User::createAndShowSubTable(session('tablename'));
                        return redirect('admin/index');
                }else{
                    return back()->with('msg','用户名或密码错误');
                }
            }else{
                return back()->with('msg','验证码错误');
            }
        }
        return view('login');
    }

    public function code()
    {
        $code = new \Code();
        $_code = $code->make()->get();
        return $_code;
    }

    public function logout(Request $request)
    {
        //清空session
        $request->flush();
        return redirect('admin/login');
    }
    public function test()
    {
//        return Crypt::encrypt(666666);
        dd(base_path());
    }
}
