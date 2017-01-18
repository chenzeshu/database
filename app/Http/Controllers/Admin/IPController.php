<?php

namespace App\Http\Controllers\Admin;

use App\Model\IP;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class IPController extends Controller
{
    public function index($fileid)
    {
        switch ($fileid){
            case "1";
                $data = IP::where('fileid',1)->paginate(10);
                session(['fileid'=>1,'filetype'=>'专利证书']);
                return view('admin.IP.index',compact('data'));
                break;
            case "2";
                $data = IP::where('fileid',2)->paginate(10);
                session(['fileid'=>2,'filetype'=>'专利受理通知书']);
                return view('admin.IP.index',compact('data'));
                break;
            case "3";
                $data = IP::where('fileid',3)->paginate(10);
                session(['fileid'=>3,'filetype'=>'商标证书']);
                return view('admin.IP.index',compact('data'));
                break;
            case "4";
                $data = IP::where('fileid',4)->paginate(10);
                session(['fileid'=>4,'filetype'=>'软件著作权证书']);
                return view('admin.IP.index',compact('data'));
                break;
            case "5";
                $data = IP::where('fileid',5)->paginate(10);
                session(['fileid'=>5,'filetype'=>'荣誉证书']);
                return view('admin.IP.index',compact('data'));
                break;
        }
    }

    public function create()
    {
        return view('admin.IP.create');
    }
    
    public function store()
    {
        $input = Input::except('_token');
        $rules = [
            'name'=>'required',
            'fileid'=>'required',
            'filepath'=>'required',
            'number'=>'required',
        ];

        $message = [
            'name.required' =>'[姓名]必须填写',
            'fileid.required' =>'[文件类型]必须选择',
            'filepath.required' =>'[文件路径]必须存在',
            'number.required' =>'[号码]必须填写',
        ];
        $validator = Validator::make($input,$rules,$message);
        if ($validator->passes()){

            $re = IP::create($input);

            if($re) {
                return redirect('admin/IP/index/'.session('fileid'));
            }else{
                return back()->with('errors','上传有误，请稍后重试！');
            }

        }else{
            return back()->withErrors($validator);
        }
    }

    public function edit($id)
    {
        $data = IP::find($id);
        return view('admin.IP.edit',compact('data'));
    }

    public function update($id)
    {
        $input = Input::except('_token','_method');
        $rules = [
            'name'=>'required',
            'fileid'=>'required',
            'filepath'=>'required',
            'number'=>'required',
        ];

        $message = [
            'name.required' =>'[姓名]必须填写',
            'fileid.required' =>'[文件类型]必须选择',
            'filepath.required' =>'[文件路径]必须存在',
            'number.required' =>'[号码]必须填写',
        ];
        $validator = Validator::make($input,$rules,$message);
        if ($validator->passes()){

            $re = IP::where('id',$id)->update($input);

            if($re) {
                return redirect('admin/IP/index/'.session('fileid'));
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

    public function search()
    {
        $input = Input::except('_token');
        $data = IP::where('name','like',"%".$input['name']."%")->where('fileid',session('fileid'))->get();
        return $data;
    }
}
