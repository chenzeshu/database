<?php

namespace App\Http\Controllers\Admin;

use App\Model\QT;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class QTController extends CommonController
{
    public function index($fileid)
    {
        switch ($fileid){
            case "1";
                $data = QT::where('fileid',1)->paginate(10);
                session(['fileid'=>1,'filetype'=>'本公司的产品第三方检测报告']);
                return view('admin.QT.index',compact('data'));
                break;
            case "2";
                $data = QT::where('fileid',2)->paginate(10);
                session(['fileid'=>2,'filetype'=>'供方产品第三方产品检测报告']);
                return view('admin.QT.index',compact('data'));
                break;
            case "3";
                $data = QT::where('fileid',3)->paginate(10);
                session(['fileid'=>3,'filetype'=>'按项目保存改装厂出厂验出资料']);
                return view('admin.QT.index',compact('data'));
                break;
            case "4";
                $data = QT::where('fileid',4)->paginate(10);
                session(['fileid'=>4,'filetype'=>'系统集成项目出厂验收文件']);
                return view('admin.QT.index',compact('data'));
                break;
            case "5";
                $data = QT::where('fileid',5)->paginate(10);
                session(['fileid'=>5,'filetype'=>'产品标准']);
                return view('admin.QT.index',compact('data'));
                break;
            case "6";
                $data = QT::where('fileid',6)->paginate(10);
                session(['fileid'=>6,'filetype'=>'对外可开展合作业务证明']);
                return view('admin.QT.index',compact('data'));
                break;
            case "7";
                $data = QT::where('fileid',7)->paginate(10);
                session(['fileid'=>7,'filetype'=>'培训证书']);
                return view('admin.QT.index',compact('data'));
                break;
            case "8";
                $data = QT::where('fileid',8)->paginate(10);
                session(['fileid'=>8,'filetype'=>'仪器计量证书']);
                return view('admin.QT.index',compact('data'));
                break;
        }
    }

    public function create()
    {
        return view('admin.QT.create');
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

            $re = QT::create($input);

            if($re) {
                return redirect('admin/QT/index/'.session('fileid'));
            }else{
                return back()->with('errors','上传有误，请稍后重试！');
            }

        }else{
            return back()->withErrors($validator);
        }
    }

    public function edit($id)
    {
        $data = QT::find($id);
        return view('admin.QT.edit',compact('data'));
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

            $re = QT::where('id',$id)->update($input);

            if($re) {
                return redirect('admin/QT/index/'.session('fileid'));
            }else{
                return back()->with('errors','上传有误，请稍后重试！');
            }

        }else{
            return back()->withErrors($validator);
        }
    }

    public function destroy($id)
    {
        $re = QT::where('id',$id)->delete();
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
        $data = QT::where('name','like',"%".$input['name']."%")->where('fileid',session('fileid'))->get();
        return $data;
    }
}
