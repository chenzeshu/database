@extends('layouts/admin')
@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <i class="fa fa-home"></i> <a href="{{url('admin/JCP')}}">首页</a> &raquo; <a href="#">{{session('filetype')}}管理</a>
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
                <a href="{{url('admin/JCP/create')}}"><i class="fa fa-plus"></i>添加{{session('filetype')}}</a>
                <a href="{{url('admin/JCP')}}"><i class="fa fa-recycle"></i>全部{{session('filetype')}}</a>
            </div>
        </div>
    </div>
    <!--结果集标题与导航组件 结束-->

    <div class="result_wrap">
        <form action="{{url('admin/JCP/')}}" method="post" enctype="multipart/form-data">
            {{csrf_field()}}
            <table class="add_tab">
                <tbody>
                    <tr>
                        <th>行业名称</th>
                        <td><input type="text" name="profession" class="lg" id="strName"></td>
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

        //todo input获得焦点
        (function showhonor() {
            $('#strName').focus();

        })()

    </script>
@endsection