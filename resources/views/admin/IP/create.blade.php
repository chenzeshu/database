@extends('layouts/admin')
@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <i class="fa fa-home"></i> <a href="{{url('admin/IP').'/'.session('fileid')}}">首页</a> &raquo; <a href="#">{{session('filetype')}}管理</a>
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
                <a href="{{url('admin/IP/create')}}"><i class="fa fa-plus"></i>添加{{session('filetype')}}</a>
                <a href="{{url('admin/IP')}}"><i class="fa fa-recycle"></i>全部{{session('filetype')}}</a>
            </div>
        </div>
    </div>
    <!--结果集标题与导航组件 结束-->
    
    <div class="result_wrap">
        <form action="{{url('admin/IP/')}}" method="post" enctype="multipart/form-data">
            {{csrf_field()}}
            <table class="add_tab">
                <tbody>
                    <tr>
                        <th>文件类型</th>
                        <td>
                            <select name="fileid" id="" onchange="show(),changeUploadFile()">
                                <option value="1" @if(session('fileid')==1) selected @endif>专利证书</option>
                                <option value="2" @if(session('fileid')==2) selected @endif>专利受理通知书</option>
                                <option value="3" @if(session('fileid')==3) selected @endif>商标证书</option>
                                <option value="4" @if(session('fileid')==4) selected @endif>软件著作权证书</option>
                                <option value="5" @if(session('fileid')==5) selected @endif>荣誉证书</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th>命名文件：</th>
                        <td>
                            <input type="text" class="lg" name="name" value="">
                            <input type="hidden" value="孙俊" name="filemanager">
                        </td>
                    </tr>
                    <tr class="else-hook">
                        <th>专利号/申请号/商标号</th>
                        <td>
                            <input type="text" name="number" class="xs">
                        </td>
                    </tr>
                    <tr class="honor-hook">
                        <th>相关产品</th>
                        <td>
                            <input type="text" name="relation" class="xs">
                        </td>
                    </tr>
                    <tr class="honor-hook">
                        <th>发放单位</th>
                        <td>
                            <input type="text" name="issue_unit" class="xs">
                        </td>
                    </tr>
                    <tr class="honor-hook">
                        <th>发放时间</th>
                        <td>
                            <input placeholder="请输入日期" class="laydate-icon" onclick="laydate()" name="issue_time">
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
                                    'uploader' : "{{url('admin/uploadfile').'/IP/'.session('fileid')}}",
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
                                    'uploader' : "{{url('admin/uploadfile').'/IP'}}/"+$('option:selected').val(),
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

    <script>
        //todo 荣誉证书展现--自执行
        (function showhonor() {
            if ("{{session('fileid')}}" == 5){
                $('.honor-hook').show()
                $('.else-hook').hide()
            }else{
                $('.honor-hook').hide()
            }
        })()
        
        function show() {
            if ($('option:selected').val() == 5){
                $('.honor-hook').show()
                $('.else-hook').hide()
            }else{
                $('.else-hook').show()
                $('.honor-hook').hide()
            }
        }
    </script>
@endsection