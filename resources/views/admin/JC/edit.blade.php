@extends('layouts/admin')
@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <i class="fa fa-home"></i> <a href="{{url('admin/JCP')}}">首页</a> &raquo; <a href="{{url('admin/JC/').'/'.session('professionid')}}">{{session('filetype')}}管理</a>
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
            <h3>编辑{{session('filetype')}}方案</h3>
        </div>
        <div class="result_content">
            <div class="short_wrap">
                <a href="{{url('admin/JC/').'/'.session('professionid')}}"><i class="fa fa-plus"></i>全部{{session('filetype')}}方案</a>
            </div>
        </div>
    </div>
    <!--结果集标题与导航组件 结束-->

    <div class="result_wrap">
        <form action="{{url('admin/JC/'.$data->id)}}" method="post">
            {{method_field('PUT')}}
            {{csrf_field()}}
            <table class="add_tab">
                <tbody>
                <input type="hidden" value="{{session('professionid')}}" name="professionid">
                <tr>
                    <th>文件类型</th>
                    <td>
                        <select name="fileid" id="" onchange="show()" class="sel_button">
                            <option value="设备配置表" @if($data['fileid']=="设备配置表") selected @endif>设备配置表</option>
                            <option value="可研报告" @if($data['fileid']=="可研报告") selected @endif>可研报告</option>
                            <option value="售前技术方案" @if($data['fileid']=="售前技术方案") selected @endif>售前技术方案</option>
                            <option value="招标技术文件" @if($data['fileid']=="招标技术文件") selected @endif>招标技术文件</option>
                            <option value="投标技术文件" @if($data['fileid']=="投标技术文件") selected @endif>投标技术文件</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th>命名文件</th>
                    <td>
                        <input type="text" class="lg" name="name" value="{{$data['name']}}">
                        <input type="hidden" value="王茹蕙" name="filemanager">
                    </td>
                </tr>
                <tr>
                    <th>车型</th>
                    <td>
                        <select name="cartype" id="" class="sel_button">
                            <option value="依维柯" @if($data['cartype']=="依维柯") selected @endif>依维柯</option>
                            <option value="奔驰" @if($data['cartype']=="奔驰") selected @endif>奔驰</option>
                            <option value="丰田" @if($data['cartype']=="丰田") selected @endif>丰田</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <link rel="stylesheet" href="{{asset('css/3area/city-picker.css')}}">
                    <script src="{{asset('js/3area/city-picker.data.js')}}"></script>
                    <script src="{{asset('js/3area/city-picker.js')}}"></script>
                    <script src="{{asset('js/3area/main.js')}}"></script>
                    <th>地区</th>
                    <td>
                        <div class="docs-methods">
                            <form class="form-inline">
                                <div id="distpicker">
                                    <div class="form-group">
                                        <div style="position: relative;">
                                            <input name="area" id="city-picker3" class="self-form" readonly type="text" value="{{$data->area}}" data-toggle="city-picker">
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
                    <th>上传文件</th>
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
                            var filetype = $('option:selected').attr('data')
                            var profession = "{{session('professionid')}}";
                            $('#file_upload').uploadify({
                                'buttonText'    : '上传文件',
                                'formData'      : {
                                    'timestamp' : '<?php echo $timestamp;?>',
                                    '_token'     : "{{csrf_token()}}"
                                },
                                'swf'      : "{{asset('/org/uploadify/uploadify.swf')}}",//这个决定了按钮有没有效
                                'uploader' : "{{url('admin/uploadfile').'/JC'}}/"+filetype+'/'+profession,
                                'onUploadSuccess'  :function (file,data,response) {
                                    $('input[name="filepath"]').attr('value',data)
                                }
                            });
                        }

                        function changeUploadFile(){
                            var filetype = $('option:selected').attr('data')
                            var profession = "{{session('professionid')}}";
                            $('#file_upload').uploadify({
                                'buttonText'    : '上传文件',
                                'formData'      : {
                                    'timestamp' : '<?php echo $timestamp;?>',
                                    '_token'     : "{{csrf_token()}}"
                                },
                                'swf'      : "{{asset('/org/uploadify/uploadify.swf')}}",//这个决定了按钮有没有效
                                'uploader' : "{{url('admin/uploadfile').'/JC'}}/"+filetype+'/'+profession,
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