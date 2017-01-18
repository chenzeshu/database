<?php

namespace App\Http\Controllers\Approve;

use App\Http\Controllers\Admin\CommonController;
use App\Model\Approve;
use App\Model\user;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;

class IndexController extends CommonController
{
    //框架主页
    public function index()
    {
        $data = Approve::where('approveman',session('user_kittyname'))->where('status',0)->get();
        $num = count($data);
        return view('index3',compact('num'));
    }

    //主页
    /**
     * 默认读取待审批表，其他状态表AJAX其他方法
     */
    public function approve()
    {
        /**
         * @name 2个人，高晓峰和钱正宇，其他人就回复：你没有权限。
         * 这里可以这样提前设计，因为最后用户名权力分发也是给的这2个人
         *
         */
        $name = session('user_kittyname');
        switch($name){
            //todo 测试时先用人名来测试，以后统一归纳改成权限
            case '钱正宇':
                $data = Approve::where('approveman',$name)->paginate(10);
                return view('approve.index',compact('data'));
                break;
            case '高晓峰':
                $data = Approve::where('approveman',$name)->paginate(10);
                return view('approve.index',compact('data'));
                break;
            default:
                return "你没有权限";
        }
    }

    //用户提交审核 store into table('arpprove')
    /**
     *  未做工作:每次提交后，临时审批表将会被清空，并新建一张记录表，用户查看状态、下载文件，也都看这个表
     */
    public function submit()
    {
        $input = Input::except('_token');

    //todo 数据维护
        $name = $input['name']; //审批表的显式名字
        $person = $input['person'];
        $watermark = $input['watermark'];
        $tablename = $input['tablename'].date('YmdHis');  //组装无法重复的数据库表名字，一个人一年最多100张表，也不多。如果一个人就要1W张，那就要合并了
        $approveman = "";
        $status = 0;  //默认存储时审核状态为审批中

    //todo 避免重复提交
        //现在允许一人同时提交N张表
//        $re = Approve::where('person',$person)->first();
//        if ($re){
//            return $res = [
//                'num'=> 0,
//                'msg'=> '你已提交过审批表，请等待之前的审批结果'
//            ];
//        }
    //todo 选择审批人
        switch ($watermark){
            case "投标":
                $approveman = "钱正宇";
                break;
            default:
                $approveman = "高晓峰";
                break;
        }
    //todo 组装数据并存储
        $data = [
            'name' =>$name,
            'watermark' =>$watermark,
            'person' =>$person,
            'tablename' => $tablename,
            'approveman' => $approveman,
            'status' =>$status
        ];
        $re = Approve::create($data);
        $re2 =Approve::createStaticTable($tablename);  //复制临时表结构及数据至新表
        DB::table(session('tablename'))->delete(); //清空临时表
        if ($re&&$re2){
            return $res = [
                'num'=> 1,
                'msg'=> '提交成功'
            ];
        }else{
            return $res = [
                'num'=> 0,
                'msg'=> '提交失败，请稍后再试'
            ];
        }
    }

    //注意：已提交的审批表，提交人的表会被冻结，即不能再进行修改，要等待审批状态改变，如：驳回
    //注意：单表调试结束后，开始测试多表，因为历史提交审批都应该有记录，所以肯定要多表
    /**
     * 管理者查看表细节
     */
    public function readTable($tablename)
    {

        $data = DB::table($tablename)->paginate(10);
        $info = Approve::where('tablename',$tablename)->first();
        return view('approve.read',compact('data','info'));
    }

    /**
     * 管理者审批业务:通过、驳回
     *
     * 特别注意：通主页默认显示待审批的表
     * 已通过与驳回状态的表，不默认显示在主页
     */
    public function passTable($id)
    {
        $re = Approve::where('id',$id)->update(['status'=>1]);
        if ($re){
            $res=[
                'status'=>0,
                'msg'=>'申请已通过'
            ];
        }else{
            $res=[
                'status'=>1,
                'msg'=>'通过失败，请稍后再试'
            ];
        }
        return $res;
    }

    public function rejTable($id)
    {
        $input = Input::except('_token','_put');
        $re = Approve::where('id',$id)->update(['status'=>2,'tips'=>$input['tips']]);
        if ($re){
            $res=[
                'status'=>0,
                'msg'=>'申请已驳回'
            ];
        }else{
            $res=[
                'status'=>1,
                'msg'=>'驳回失败,请稍后再试'
            ];
        }
        return $res;
    }

    //按审批状态显示
    public function approveStatus($option)
    {
        $data = Approve::where('status',$option)->get();
        $count = sizeof($data);
        if ($count){
            $res=[
                'status'=>0,
                'data'=>$data
            ];
        }else{
            $res=[
                'status'=>1,
                'msg'=>'11'
            ];
        }
        return $res;
    }
    //注册用户
    public function register()
    {
        if ($input = Input::except('_token')){
            $rules = [
                'name'=>'required',
                'password'=>'required|between:6,20|confirmed',
                'kittyname'=>'required',
            ];

            $message = [
                'name.required' =>'[登录id]必须填写',
                'passowrd.required' =>'[密码]必须填写',
                'password.between'=> '[密码]长度应在6-20位',
                'password.confirmed'=> '[两次填写密码]不一致',
                'kittyname.required' =>'[用户真实姓名]必须填写',
            ];
            $validator = Validator::make($input,$rules,$message);
            if ($validator->passes()){
                //去掉验证密码
                unset($input['password_confirmation']);
                //查询是否已有此用户名
                $user = user::where('name',$input['name'])->first();
                if (!$user){
                    //加密密码
                    $input['password'] = Crypt::encrypt($input['password']);
                    $re = user::create($input);

                    if($re) {
                        return back()->with('errors','注册成功！');
                    }else{
                        return back()->with('errors','提交有误，请稍后重试！');
                    }
                }else{
                    return back()->with('errors','用户名已存在!');
                }
            }else{
                return back()->withErrors($validator);
            }
        }
        return view('Approve.register');
    }

    public function showInfo($id)
    {
        $info = Approve::find($id);
        return $info->tips;
    }
}
