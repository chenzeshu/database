@extends('layouts/admin')
@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <i class="fa fa-home"></i> <a href="{{url('admin/PR').'/'.session('fileid')}}">首页</a> &raquo; <a href="#">{{session('filetype')}}管理</a>
    </div>
    <!--面包屑导航 结束-->
    <div class="result_wrap">
        <div class="result_title">
            <div class="mark">
                @if(is_object($errors))
                    @if(count($errors)>0)
                        @foreach($errors->all() as $error)
                            <p>{{$error}}</p>
                        @endforeach
                    @endif
                @else
                    <p>{{$errors}}</p>
                @endif
            </div>
        </div>
    </div>
	<!--结果集标题与导航组件 开始-->
	<div class="result_wrap">
        <div class="result_title">
            <h3>编辑{{session('filetype')}}</h3>
        </div>
        <div class="result_content">
            <div class="short_wrap">
                <a href="{{url('admin/PR/create')}}"><i class="fa fa-plus"></i>添加{{session('filetype')}}</a>
                <a href="{{url('admin/PR')}}"><i class="fa fa-recycle"></i>全部{{session('filetype')}}</a>
            </div>
        </div>
    </div>
    <!--结果集标题与导航组件 结束-->

    <div class="result_wrap">
        <form action="{{url('admin/PR/'.$data->id)}}" method="post">
            <input type="hidden" name="_method" value="put">
            {{csrf_field()}}
            <table class="add_tab">
                <tbody>
                <tr>
                    <th>文件类型</th>
                    <td>
                        <select name="fileid" id="">
                            <option value="1" @if($data['fileid']==1) selected @endif>个人证件照</option>
                            <option value="2" @if($data['fileid']==2) selected @endif>身份证</option>
                            <option value="3" @if($data['fileid']==3) selected @endif>学历学位</option>
                            <option value="4" @if($data['fileid']==4) selected @endif>职称证书</option>
                            <option value="5" @if($data['fileid']==5) selected @endif>培训证书</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th>姓名：</th>
                    <td>
                        <input type="text" class="xs" name="name" value="{{$data->name}}">
                        <input type="hidden" value="曹华" name="filemanager">
                    </td>
                </tr>
                <tr>
                    <th>文件</th>
                    <td>
                        <input type="text" name="filepath" class="lg" value="{{$data->filepath}}">
                        <input id="file_upload" name="file_upload" type="file" multiple="true">
                    </td>
                    <script src="{{asset('/org/uploadify/jquery.uploadify.min.js')}}" type="text/javascript"></script>
                    <link rel="stylesheet" type="text/css" href="{{asset('/org/uploadify/uploadify.css')}}">
                    <script type="text/javascript">
                        <?php $timestamp = time();?>
                        init()

                        function init() {
                            uploadFile()
                        }

                        function uploadFile() {
                            $('#file_upload').uploadify({
                                'buttonText'    : '上传文件',
                                'formData'      : {
                                    'timestamp' : '<?php echo $timestamp;?>',
                                    '_token'     : "{{csrf_token()}}"
                                },
                                'swf'      : "{{asset('/org/uploadify/uploadify.swf')}}",//这个决定了按钮有没有效
                                'uploader' : "{{url('admin/uploadfile').'/PR/'.session('fileid')}}",
                                'onUploadSuccess'  :function (file,data,response) {
                                    $('input[name="filepath"]').attr('value',data)
                                }
                            });
                        }

                        function changeUploadFile(){
                            $('#file_upload').uploadify({
                                'buttonText'    : '上传文件',
                                'formData'      : {
                                    'timestamp' : '<?php echo $timestamp;?>',
                                    '_token'     : "{{csrf_token()}}"
                                },
                                'swf'      : "{{asset('/org/uploadify/uploadify.swf')}}",//这个决定了按钮有没有效
                                'uploader' : "{{url('admin/uploadfile').'/PR'}}/"+$('option:selected').val(),
                                'onUploadSuccess'  :function (file,data,response) {
                                    $("input[name='filepath']").attr('value',data)
                                }
                            });
                        }
                    </script>
                    <style>
                        .uploadify{
                            display: inline-block;}
                        .uploadify-button{border:none;border-radius: 5px;
                            margin-top:8px;}
                        table.add_tab tr td span.uploadify-button-text{color:#FFF;margin:0}
                    </style>
                </tr>
                <tr>
                    <th></th>
                    <td>
                        <input type="submit" value="提交">
                        <input type="button" class="back" onclick="history.go(-1)" value="返回">
                    </td>
                </tr>
                </tbody>
            </table>
        </form>
    </div>

@endsection