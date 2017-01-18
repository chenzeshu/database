@extends('layouts.admin')
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
                <h3 class="personal-title">{{session('filetype')}}</h3>
            </div>
            <!--快捷导航 开始-->
            <div class="result_content">
                <div class="short_wrap">
                    {{--<a href="#" class="fr sp_button"><span class="subtable-hook">未提交审批</span></a>--}}
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
                        <th>审批表名</th>
                        <th>水印</th>
                        <th>审批负责人</th>
                        <th>审批状态</th>
                        <th>提交时间</th>
                        <th>审批通过时间</th>
                    </tr>
                    <div style="display: none">{{$num=1}}</div>
                    @foreach($data as $v)
                    <tr>
                        <td class="tc">{{$num++}}</td>
                        <td>
                            <a href="{{url('sub/readhistory').'/'.$v->tablename}}">{{$v->name}}</a>
                        </td>
                        <td>
                            {{$v->watermark}}
                        </td>
                        <td>
                            {{$v->approveman}}
                        </td>
                        <td>
                            <span class="personal-state-wrapper
                           @if($v->status == 0)
                                    state2">审批中
                                @elseif($v->status == 1)
                                    state3">审批通过
                                @elseif($v->status == 2)
                                    state4" onclick="showInfo({{$v->id}})">审批未通过
                                @endif
                            </span>
                        </td>
                        <td>
                            {{$v->created_at}}
                        </td>
                        <td>
                            @if($v->status == 1)
                                {{$v->updated_at}}
                            @else
                                还没有通过审批
                            @endif
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
        //todo 驳回理由弹出层
        function showInfo(id) {
            console.log(id)
            $.post("{{url('approve/showinfo')}}/"+id,{'_token':"{{csrf_token()}}"},function (data) {
                console.log(data)
                //页面层
                layer.open({
                    type: 1,
                    skin: 'layui-layer-rim', //加上边框
                    area: ['630px', '160px'], //宽高
                    content: '<div class="showinfo-wrapper"><span class="showinfo"><b>驳回理由：</b>'+data+'</span></div>'
                });

            })
        }
    </script>
@endsection
