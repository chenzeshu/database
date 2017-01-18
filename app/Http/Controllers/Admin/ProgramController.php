<?php

namespace App\Http\Controllers\Admin;

use App\Model\Program;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class ProgramController extends CommonController
{
    public function index($fileid)
    {
        switch ($fileid){
            case "1";
                $data = Program::where('fileid',1)->paginate(10);
                session(['fileid'=>1,'filetype'=>'中标通知书']);
                return view('admin.Program.index',compact('data'));
                break;
            case "2";
                $data = Program::where('fileid',2)->paginate(10);
                session(['fileid'=>2,'filetype'=>'验收报告']);
                return view('admin.Program.index',compact('data'));
                break;
            case "3";
                $data = Program::where('fileid',3)->paginate(10);
                session(['fileid'=>3,'filetype'=>'感谢信']);
                return view('admin.Program.index',compact('data'));
                break;
            case "4";
                $data = Program::where('fileid',4)->paginate(10);
                session(['fileid'=>4,'filetype'=>'合同']);
                return view('admin.Program.index',compact('data'));
                break;
            case "5";
                $data = Program::where('fileid',5)->paginate(10);
                session(['fileid'=>5,'filetype'=>'招标文件']);
                return view('admin.Program.index',compact('data'));
                break;
            case "6";
                $data = Program::where('fileid',6)->paginate(10);
                session(['fileid'=>6,'filetype'=>'投标文件']);
                return view('admin.Program.index',compact('data'));
                break;
            case "7";
                $data = Program::where('fileid',7)->paginate(10);
                session(['fileid'=>7,'filetype'=>'变更资料']);
                return view('admin.Program.index',compact('data'));
                break;
            case "8";
                $data = Program::where('fileid',8)->paginate(10);
                session(['fileid'=>8,'filetype'=>'资质']);
                return view('admin.Program.index',compact('data'));
                break;
        }
    }

    public function create()
    {
        return view('admin.Program.create');
    }
    public function store()
    {
        $input = Input::except('_token');
        $rules = [
            'name'=>'required',
            'fileid'=>'required',
            'filepath'=>'required',
            'profession'=>'required',
            'area'=>'required',
            'PM'=>'required',
            'sum'=>'required'
        ];

        $message = [
            'name.required' =>'[姓名]必须填写',
            'fileid.required' =>'[文件类型]必须选择',
            'filepath.required' =>'[文件路径]必须存在',
            'profession.required' =>'[行业]必须填写',
            'area.required' =>'[区域]必须填写',
            'PM.required' =>'[项目经理]必须填写',
            'sum.required' =>'[金额]必须填写',
        ];
        $validator = Validator::make($input,$rules,$message);
        if ($validator->passes()){

            //date转换unix时间戳
            $input['valid_time'] = strtotime($input['valid_time']);

            $re = Program::create($input);

            if($re) {
                return redirect('admin/PRO/index/'.session('fileid'));
            }else{
                return back()->with('errors','上传有误，请稍后重试！');
            }

        }else{
            return back()->withErrors($validator);
        }
    }

    public function edit($id)
    {
        $data = Program::find($id);
        return view('admin.Program.edit',compact('data'));
    }

    public function update($id)
    {
        $input = Input::except('_token','_method');
        $rules = [
            'name'=>'required',
            'fileid'=>'required',
            'filepath'=>'required',
            'profession'=>'required',
            'area'=>'required',
            'PM'=>'required',
            'sum'=>'required'
        ];

        $message = [
            'name.required' =>'[姓名]必须填写',
            'fileid.required' =>'[文件类型]必须选择',
            'filepath.required' =>'[文件路径]必须存在',
            'profession.required' =>'[行业]必须填写',
            'area.required' =>'[区域]必须填写',
            'PM.required' =>'[项目经理]必须填写',
            'sum.required' =>'[金额]必须填写',
        ];
        $validator = Validator::make($input,$rules,$message);
        if ($validator->passes()){
            //date转换unix时间戳
            $input['valid_time'] = strtotime($input['valid_time']);


            $re = Program::where('id',$id)->update($input);

            if($re) {
                return redirect('admin/PRO/index/'.session('fileid'));
            }else{
                return back()->with('errors','上传有误，请稍后重试！');
            }

        }else{
            return back()->withErrors($validator);
        }
    }

    public function destroy($id)
    {
        $re = Program::where('id',$id)->delete();
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
        //转换时间
        $time = strtotime($input['validtime']);
        $data = Program::where('name','like',"%".$input['name']."%")
            ->where('profession','like',"%".$input['profession']."%")
            ->where('area','like',"%".$input['area']."%")
            ->where('PM','like',"%".$input['PM']."%")
            ->where('sum','like',"%".$input['sum']."%")
            ->where('valid_time','<',$time)
            ->where('fileid',session('fileid'))
            ->get();
        return $data;
    }
}
