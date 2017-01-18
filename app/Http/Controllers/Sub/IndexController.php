<?php

namespace App\Http\Controllers\Sub;

use App\Http\Controllers\Admin\CommonController;
use App\Model\Approve;
use App\Model\user;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class IndexController extends CommonController
{
    /**
     * 展出第二个主页面iframe骨架
     */
    public function index()
    {
        $data = Approve::where('approveman',session('user_name'))->where('status',0)->get();
        $num = count($data);
        return view('index2',compact('num'));
    }

    /**
     * 提交历史,从approve表中拿到跟自己有关的
     * 类似购物车
     * 每次审批表提交后，都会把表中选择的文件打包形成一个清单提交，同时，原审批表中的文件记录被删除
     * 下载都是去形成的清单下载，而清单自带了时间戳，可以判定权限。
     */
    public function history()
    {
        //todo
        $data = Approve::where('person',session('user_kittyname'))->paginate(15);
        session(['filetype'=>'审批历史']);
        return view('sub/history',compact('data'));
    }

    public function readHistory($tablename)
    {
        $data = DB::table($tablename)->paginate(15);
        $table = Approve::where('tablename',$tablename)->first();
        session(['filetype'=>$table['name'],'temptable'=>$tablename]);
        return view('sub/read',compact('data','table'));
    }
    /**
     *  创建/展出个人审批表
     */
    public function subTable()
    {
        //todo 改变session('filetype')
        session(['filetype'=>'个人审批表']);

        //todo 构造表名,前缀为zw_da_
        $table_name = session('user_name').'_subtable'; //目前限定一张表
        session(['tablename'=>$table_name]);

        //todo 建表/秀表
            //在登录时已经做了，如果在这里才执行，新用户会由于$num参数而报错
//        user::createAndShowSubTable($table_name);

        //todo 读表数据并展示
        $data = DB::table($table_name)->paginate(10);
        return view('sub.index',compact('data'));
    }

    /**
     * 添加审批表
     *
     */
    public function add()
    {
        $input = Input::except('_token');
        /**
         * @model 数据表名
         * @filehome 文件归属
         */
        $model = $input['model'];
        $filehome = $input['filehome'];
        switch ($input['model']){
            default:
                if (isset($input['id'])){
                    $data = array();

                    foreach ($input['id'] as $k=>$v){
                        $_data = DB::table($model)->where('id',$v)->get();
                        foreach ($_data as $m=>$n){
                            $data[$k]['filename'] = $n->name;
                            $data[$k]['filepath'] = $n->filepath;
                            $data[$k]['filehome'] = $filehome;
                        }
                    }

                    $re = DB::table(session('tablename'))->insert($data);
                    if ($re){
                        $res = [
                          'status' => 0,
                            'msg' => '添加成功'
                        ];
                    }else{
                        $res = [
                            'status' => 1,
                            'msg' => '添加失败，稍后再试'
                        ];
                    }
                    return $res;
                }else{
                    $res = [
                        'status' => 1,
                        'msg' => '没有选择内容！'
                    ];
                }
                return $res;
                break;
            //todo 集成规划所分二级，而二级里把5类文件放一起了，不做三级不然太深。所以要写个case
            //万幸：JC我把fileid直接写成了中文
            case "JC":
                if (isset($input['id'])){
                    $data = array();

                    foreach ($input['id'] as $k=>$v){
                        $_data = DB::table($model)->where('id',$v)->get();
                        foreach ($_data as $m=>$n){
                            $data[$k]['filename'] = $n->name;
                            $data[$k]['filepath'] = $n->filepath;
                            $data[$k]['filehome'] = $filehome.'/'.$n->fileid;
                        }

                    }

                    $re = DB::table(session('tablename'))->insert($data);
                    if ($re){
                        $res = [
                            'status' => 0,
                            'msg' => '添加成功'
                        ];
                    }else{
                        $res = [
                            'status' => 1,
                            'msg' => '添加失败，稍后再试'
                        ];
                    }
                    return $res;
                }else{
                    $res = [
                        'status' => 1,
                        'msg' => '没有选择内容！'
                    ];
                }
                return $res;
                break;
            /**
             * 以下是没有采取复用的代码，以备不时之需
             */
//            case "IP":
//                if ($id = isset($input['id'])){
//                    $data = array();
//                    foreach ($input['id'] as $k=>$v){
//                        $_data = IP::find($v);
//                        $data[$k]['filename'] = $_data['name'];
//                        $data[$k]['filepath'] = $_data['filepath'];
//                    }
//                    $re = DB::table($tablename)->insert($data);
//                    if ($re){
//                        $res = [
//                            'status' => 0,
//                            'msg' => '添加成功'
//                        ];
//                    }else{
//                        $res = [
//                            'status' => 1,
//                            'msg' => '添加失败，稍后再试'
//                        ];
//                    }
//                    return $res;
//                }else{
//                    $res = [
//                        'status' => 1,
//                        'msg' => '没有选择内容！'
//                    ];
//                }
//                return $res;
//                break;
//            case "QT":
//                if ($id = isset($input['id'])){
//                    $data = array();
//                    foreach ($input['id'] as $k=>$v){
//                        $_data = QT::find($v);
//                        $data[$k]['filename'] = $_data['name'];
//                        $data[$k]['filepath'] = $_data['filepath'];
//                    }
//                    $re = DB::table($tablename)->insert($data);
//                    if ($re){
//                        $res = [
//                            'status' => 0,
//                            'msg' => '添加成功'
//                        ];
//                    }else{
//                        $res = [
//                            'status' => 1,
//                            'msg' => '添加失败，稍后再试'
//                        ];
//                    }
//                    return $res;
//                }else{
//                    $res = [
//                        'status' => 1,
//                        'msg' => '没有选择内容！'
//                    ];
//                }
//                return $res;
//                break;
//            case "PR":
//                if ($id = isset($input['id'])){
//                    $data = array();
//                    foreach ($input['id'] as $k=>$v){
//                        $_data = Personal::find($v);
//                        $data[$k]['filename'] = $_data['name'];
//                        $data[$k]['filepath'] = $_data['filepath'];
//                    }
//                    $re = DB::table($tablename)->insert($data);
//                    if ($re){
//                        $res = [
//                            'status' => 0,
//                            'msg' => '添加成功'
//                        ];
//                    }else{
//                        $res = [
//                            'status' => 1,
//                            'msg' => '添加失败，稍后再试'
//                        ];
//                    }
//
//                }else{
//                    $res = [
//                        'status' => 1,
//                        'msg' => '没有选择内容！'
//                    ];
//                }
//                return $res;
//                break;
//            case "program":
//                if ($id = isset($input['id'])){
//                    $data = array();
//
//                    foreach ($input['id'] as $k=>$v){
//                        $_data = Program::find($v);
//                        $data[$k]['filename'] = $_data['name'];
//                        $data[$k]['filepath'] = $_data['filepath'];
//                    }
//                    $re = DB::table($tablename)->insert($data);
//                    if ($re){
//                        $res = [
//                            'status' => 0,
//                            'msg' => '添加成功'
//                        ];
//                    }else{
//                        $res = [
//                            'status' => 1,
//                            'msg' => '添加失败，稍后再试'
//                        ];
//                    }
//                    return $res;
//                }else{
//                    $res = [
//                        'status' => 1,
//                        'msg' => '没有选择内容！'
//                    ];
//                }
//                return $res;
//                break;
//            default:
//                return "没有内容";
        }
    }

    public function destroy($id)
    {
        $re = DB::table(session('tablename'))->where('id',$id)->delete();;
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

    public function pass()
    {
        if ($input = Input::except('_token')) {
            $rules = [
                'password_o' => 'required',
                'password' => 'required|between:6,20|confirmed',
            ];

            $message = [
                'password_o.required' => '[原密码]必须填写',
                'passowrd.required' => '[密码]必须填写',
                'password.between' => '[密码]长度应在6-20位',
                'password.confirmed' => '[两次填写密码]不一致'
            ];
            $validator = Validator::make($input, $rules, $message);
            if ($validator->passes()) {

                $user = user::find(session('user_id'));

                if (Crypt::decrypt($user['password']) == $input['password_o']) {
                    //加密密码
                    $input['password'] = Crypt::encrypt($input['password']);
                    $re = user::where('id',session('user_id'))->update(['password' => $input['password']]);
                    if ($re) {
                        return back()->with('errors', '修改成功！');
                    } else {
                        return back()->with('errors', '提交有误，请稍后重试！');
                    }
                }

            } else {
                return back()->withErrors($validator);
            }
        }
        return view('sub.pass');
    }
}
