@extends('layouts/admin')
@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i>。-->
        <i class="fa fa-home"></i> <a href="{{url('approve')}}">{{session('user_name')}}处理审批</a> &raquo; <a href="#">审批</a>
    </div>
    <!--面包屑导航 结束-->

    <!--搜索结果页面 列表 开始-->
        <div class="result_wrap">
            <div class="result_title">
                <h3 class="personal-title">{{session('user_name')}}的待审批目录</h3>
                {{--<div class="personal-state-wrapper state1">--}}
                    {{--<span class="personal-state">未提交</span>--}}
                {{--</div>--}}
            </div>
            <!--快捷导航 开始-->
            <div class="result_content">
                <div class="short_wrap">
                    <select name="" id="approveStatus" class="sel_button" onchange="approveStatus()">
                        <option value="">审批状态</option>
                        <option value="0">待审批</option>
                        <option value="1">已通过</option>
                        <option value="2">未通过</option>
                        <option value='3'>显示全部</option>
                    </select>
                    <input type="text" name="" value="" placeholder="填写申请人姓名">
                    <input type="button" value="搜索" onclick="searchName()">
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
                        <th>表名</th>
                        <th>申请用途（水印）</th>
                        <th>申请人</th>
                        {{--<th class="else-hook">审批人</th>--}}
                        <th>审批状态</th>
                        <th>最后修改时间</th>
                        <th colspan="2" style="text-align: center">操作</th>
                    </tr>
                    <div style="display: none">{{$num=1}}</div>
                <tbody>
                @if(isset($data))
                    @foreach($data as $v)
                    <tr>
                        <td class="tc">{{$num++}}</td>
                        <td>
                            <a href="{{url('approve/readtable').'/'.$v->tablename}}">{{$v->name}}</a>
                            {{--点击水印可以查看申请人的求审批表--}}
                        </td>
                        <td>
                            {{$v->watermark}}
                        </td>
                        <td>
                            {{$v->person}}
                        </td>
                        {{--<td class="else-hook">--}}
                            {{--{{$v->approveman}}--}}
                        {{--</td>--}}
                        <td>
                            <span class="personal-state-wrapper
                           @if($v->status == 0)
                                state2">审批中
                           @elseif($v->status == 1)
                                state3">审批通过
                           @elseif($v->status == 2)
                                state4" onclick="showInfo({{$v->id}})">审批未过
                           @endif
                            </span>
                        </td>
                        <td>
                            {{$v->updated_at}}
                        </td>
                        <td>
                            <a href="javascript:"onclick="passObj({{$v->id}})">通过</a>
                        </td>
                        <td>
                            <a href="javascript:"onclick="rejectObj({{$v->id}})">驳回</a>
                            {{--驳回要写驳回理由--}}
                        </td>
                    </tr>
                    @endforeach
                @endif
                </tbody>
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
        //通过审批
        function passObj(id){
            layer.confirm('通过审批？', {
                btn: ['确定','取消'] //按钮
            }, function(){
                $.post("{{url('approve/pass/')}}/"+id,{'_method':'put','_token':"{{csrf_token()}}"},function(data){
                    if(data.status=='0'){
                        layer.msg(data.msg, {icon: 6});
                        setTimeout(function(){
                            location.href = location.href;
                        },900)
                    }else if(data.status=='1'){
                        layer.msg(data.msg, {icon: 5});
                        setTimeout(function(){
                            location.href = location.href;
                        },900)
                    }else{
                        layer.msg(data.msg, {icon: 5});
                        setTimeout(function(){
                            location.href = location.href;
                        },900)
                    }
                });
            });
        }
        //驳回审批
        function rejectObj(id){
            layer.prompt({title: '请填写驳回原因', formType: 3}, function(tips, index){
                layer.close(index);

                //todo 组装成对象方便维护
                var data={
                    'tips':tips,
                    '_method':'put',
                    "_token":"{{csrf_token()}}"
                };

                $.post("{{url('approve/rej/')}}/"+id,data,function (data) {
                    if (data.num == 0){
                        layer.msg(data.msg, {icon: 5});
                        setTimeout(function(){
                            location.href = location.href;
                        },900)
                    }else {
                        layer.msg(data.msg, {icon: 6});
                        setTimeout(function(){
                            location.href = location.href;
                        },900)
                    }

                })
            });
        }

        //todo 按审批状态筛选
        /**
         * 默认status = 0 ，待审批
         * status = 1 ，通过
         * status =2 ,拒绝
         */
        function approveStatus() {

            var val = $('#approveStatus option:selected').val()
            $.post("{{url('approve/approvestatus')}}/"+val,{'_token':"{{csrf_token()}}"},function (data) {
                $('tr:gt(0)').remove()
                if (data.status==0){
                    var num = 1;
                    $(data.data).each(function (k,v) {
                        var herf = "{{url('approve/readtable')}}/"+v.tablename
                        var status = '';
                        if (v.status==0){
                            status = 'state2">审批中';
                        }else if(v.status==1){
                            status = 'state3">审批通过'
                        }else if (v.status==2){
                            status = 'state4">审批未过'
                        }
                        $('tr:last').after('<tr><td class="tc">'+num+'</td><td><a href="'+herf+'">'+v.name+'</a></td>' +
                            '<td>'+v.watermark+'</td><td>'+v.approveman+'</td>' +
                            '<td><span class=\"personal-state-wrapper '+status+'</td>' +
                            '<td>'+v.updated_at+'</td>' +
                            '<td><a href="javascript:onclick=passObj('+v.id+')">通过</a></td><td><a href="javascript:onclick=rejectObj('+v.id+')">驳回</a></td><tr>')
                        num++ ;
                    })
                }else if(data.status==1){
                    $('tr:first').after('<tr><td colspan="7" class="tc" style=";font-weight: bold">此状态下没有表单</td></tr>')
                }
            })
        }

        //todo 驳回理由弹出层
        function showInfo(id) {
            $.post("{{url('approve/showinfo')}}/"+id,{'_token':"{{csrf_token()}}"},function (data) {
                console.log(data)
                //页面层
                layer.open({
                    type: 1,
                    skin: 'layui-layer-rim', //加上边框
                    area: ['630px', '160px'], //宽高
                    content: '<div class="showinfo-wrapper"><b>驳回理由：</b><span class="showinfo">'+data+'</span></div>'
                });

            })
        }
    </script>
@endsection
