<?php

namespace App\Http\Controllers\Admin;

use App\Model\JC;
use App\Model\JC_PROFESSION;
use App\Model\Program;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class JCController extends CommonController
{
    public function index($id)
    {
        switch ($id){
            
            default:
                $profession = JC_PROFESSION::find($id);
                $data = JC::where('professionid',$id)->orderBy('id')->paginate(10);
//                session(['professionid'=>1,'filetype'=>$profession['profession']]);
                session(['professionid'=>$id,'filetype'=>$profession['profession']]);
                return view('admin.JC.index',compact('data'));
        }
    }

    public function create()
    {
        return view('admin.JC.create');

    }
    public function store()
    {
        $input = Input::except('_token');
        $rules = [
            'name'=>'required',
            'fileid'=>'required',
            'filepath'=>'required',
            'cartype'=>'required',
            'area'=>'required'
        ];

        $message = [
            'name.required' =>'[姓名]必须填写',
            'fileid.required' =>'[文件类型]必须选择',
            'filepath.required' =>'[文件路径]必须存在',
            'cartype.required' =>'[车型]必须选择',
            'area.required' =>'[地区]必须选择',
        ];
        $validator = Validator::make($input,$rules,$message);
        if ($validator->passes()){

            $re = JC::create($input);
            if($re) {
                return redirect('admin/JC/index/'.session('professionid'));
            }else{
                return back()->with('errors','上传有误，请稍后重试！');
            }

        }else{
            return back()->withErrors($validator);
        }
    }

    public function edit($id)
    {
        $data = JC::find($id);
        return view('admin.JC.edit',compact('data'));
    }

    public function update($id)
    {
        $input = Input::except('_token','_method');
        $rules = [
            'name'=>'required',
            'fileid'=>'required',
            'filepath'=>'required',
            'cartype'=>'required',
            'area'=>'required'
        ];

        $message = [
            'name.required' =>'[姓名]必须填写',
            'fileid.required' =>'[文件类型]必须选择',
            'filepath.required' =>'[文件路径]必须存在',
            'cartype.required' =>'[车型]必须选择',
            'area.required' =>'[地区]必须选择',
        ];
        $validator = Validator::make($input,$rules,$message);
        if ($validator->passes()){

            $re = JC::where('id',$id)->update($input);

            if($re) {
                return redirect('admin/JC/index/'.session('professionid'));
            }else{
                return back()->with('errors','上传有误，请稍后重试！');
            }

        }else{
            return back()->withErrors($validator);
        }
    }

    public function destroy($id)
    {
        $re = JC::where('id',$id)->delete();
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
        $data = JC::where('name','like',"%".$input['name']."%")
//            ->where('profession','like',"%".$input['profession']."%")
//            ->where('area','like',"%".$input['area']."%")
//            ->where('PM','like',"%".$input['PM']."%")
//            ->where('sum','like',"%".$input['sum']."%")
//            ->where('valid_time','like',"%".$input['validtime']."%")
            ->where('fileid',session('fileid'))
            ->get();
        return $data;
    }
}
