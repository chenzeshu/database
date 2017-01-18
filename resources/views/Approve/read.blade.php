@extends('layouts/admin')
@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> -->
        <i class="fa fa-home"></i> <a href="{{url('admin/PR').'/'.session('fileid')}}">{{session('user_name')}}</a> &raquo; <a href="#">提交审批表</a>
    </div>
    <!--面包屑导航 结束-->

    <!--搜索结果页面 列表 开始-->
        <div class="result_wrap">
            <div class="result_title">
               <h3 class="personal-title">表名：{{session('filetype')}}</h3>
                    <span class="personal-state-wrapper
                           @if($info->status == 0)
                            state2">审批中
                        @elseif($info->status == 1)
                            state3">审批通过
                        @elseif($info->status == 2)
                            state4" onclick="showInfo({{$info->id}})">审批未过
                        @endif
                    </span>
            </div>
            <!--快捷导航 开始-->
            <div class="result_content">
                <div class="short_wrap">
                    <input type="button" class="back" onclick="history.go(-1)" value="返回">
                </div>
            </div>
            <!--快捷导航 结束-->
        </div>
        <div class="result_wrap">
            <div class="result_content">
                <table class="list_tab">
                    <tr>
                        {{--<th class="tc">ID</th>--}}
                        <th class="tc">ID</th>
                        <th>文件名</th>
                        <th>文件归属</th>
                        <th>下载次数</th>
                        <th>最后修改时间</th>
                    </tr>
                    <div style="display: none">{{$num=1}}</div>
                    @foreach($data as $v)
                    <tr>
                        <td class="tc">{{$num++}}</td>
                        <td>
                            <a href="#">{{$v->filename}}</a>
                        </td>
                        <td>
                            {{$v->filehome}}
                        </td>
                        <td></td>
                        <td>
                            {{$v->updated_at}}
                        </td>
                    </tr>
                    @endforeach
                </table>
                <div class="page_list">
                   {{$data->links()}}
                </div>
            </div>
        </div>
    <!--搜索结果页面 列表 结束-->
    <style>
        .result_content ul li span{
            padding:6px 12px;
        }
    </style>
    <script>
        $(function () {
            init();
        })

        function init() {

        }
    </script>
@endsection
