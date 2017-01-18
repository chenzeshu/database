@extends('layouts/admin')
@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <i class="fa fa-home"></i> <a href="{{url('admin/PR').'/'.session('fileid')}}">首页</a> &raquo; <a href="#">项目管理</a>
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
            <h3>添加{{session('filetype')}}</h3>
        </div>
        <div class="result_content">
            <div class="short_wrap">
                <a href="{{url('admin/PRO/create')}}"><i class="fa fa-plus"></i>添加{{session('filetype')}}</a>
                <a href="{{url('admin/PRO')}}"><i class="fa fa-recycle"></i>全部{{session('filetype')}}</a>
            </div>
        </div>
    </div>
    <!--结果集标题与导航组件 结束-->
    
    <div class="result_wrap">
        <form action="{{url('admin/PRO/')}}" method="post" enctype="multipart/form-data">
            {{csrf_field()}}
            <table class="add_tab">
                <tbody>
                    <tr>
                        <th>文件类型</th>
                        <td>
                            <select name="fileid" id="">
                                <option value="1" @if(session('fileid')==1) selected @endif>中标通知书</option>
                                <option value="2" @if(session('fileid')==2) selected @endif>验收报告</option>
                                <option value="3" @if(session('fileid')==3) selected @endif>感谢信</option>
                                <option value="4" @if(session('fileid')==4) selected @endif>合同</option>
                                <option value="5" @if(session('fileid')==5) selected @endif>投标文件</option>
                                <option value="6" @if(session('fileid')==6) selected @endif>招标文件</option>
                                <option value="7" @if(session('fileid')==7) selected @endif>变更资料</option>
                                <option value="8" @if(session('fileid')==8) selected @endif>资质</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th>命名文件：</th>
                        <td>
                            <input type="text" class="lg" name="name" value="">
                            <input type="hidden" value="钱正宇" name="filemanager">
                        </td>
                    </tr>
                    <tr>
                        <th>行业</th>
                        <td>
                            <input type="text" class="xs" name="profession">
                        </td>
                    </tr>
                    <tr>
                        <link rel="stylesheet" href="{{asset('css/3area/city-picker.css')}}">
                        <script src="{{asset('js/3area/city-picker.data.js')}}"></script>
                        <script src="{{asset('js/3area/city-picker.js')}}"></script>
                        <script src="{{asset('js/3area/main.js')}}"></script>
                        <th>区域</th>
                        <td>
                            <div class="docs-methods">
                                <form class="form-inline">
                                    <div id="distpicker">
                                        <div class="form-group">
                                            <div style="position: relative;">
                                                <input name="area" id="city-picker3" class="self-form" readonly type="text" value="江苏省/南京市/浦口区" data-toggle="city-picker">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <button class="self-btn self-btn-warn" id="reset" type="button">重置</button>
                                            <button class="self-btn self-btn-danger" id="destroy" type="button">确定</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th>项目经理</th>
                        <td>
                            <input type="text" class="xs" name="PM">
                        </td>
                    </tr>
                    <tr>
                        <th>金额</th>
                        <td>
                            <input type="text" class="xs" name="sum">
                        </td>
                    </tr>
                    <tr id="valid">
                        <th>合同生效时间</th>
                        <td>
                            <input placeholder="请输入日期" class="laydate-icon" onclick="laydate()" name="valid_time">
                        </td>
                    </tr>
                    <tr>
                        <th>上传文件</th>
                        <td>
                            <input type="text" name="filepath" class="lg">
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
                                    'uploader' : "{{url('admin/uploadfile').'/PRC/'.session('fileid')}}",
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
                                    'uploader' : "{{url('admin/uploadfile').'/PRC'}}/"+$('option:selected').val(),
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