@extends('layouts/admin')
@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/JCP')}}">首页</a> &raquo; <a href="#">{{session('filetype')}}</a>
    </div>
    <!--面包屑导航 结束-->

    <!--搜索结果页面 列表 开始-->
        <div class="result_wrap">
            <div class="result_title">
                <span class="fl">行业：</span><h3 class="personal-title">{{session('filetype')}}</h3>
            </div>
            <!--快捷导航 开始-->
            <div class="result_content">
                <div class="short_wrap">
                    <a href="{{url('admin/JC/create')}}"><i class="fa fa-plus"></i>添加{{session('filetype')}}方案</a>
                    <input type="text" name="kao_name" class="xs" placeholder="填写方案名称" id="search">
                    <input type="button" value="查找" onclick="searchName()">
                    <select name="" id="" class="sel_button">
                        <option value="">下拉选择车型</option>
                        <option value="">依维柯</option>
                        <option value="">奔驰</option>
                        <option value="">丰田</option>
                    </select>
                    <select name="" id="" class="sel_button">
                        <option value="">下拉选择文件类型</option>
                        <option value="">设备配置表</option>
                        <option value="">可研报告</option>
                        <option value="">售前技术方案</option>
                        <option value="">招标技术文件</option>
                        <option value="">投标技术文件</option>
                    </select>
                    <tr>
                        <link rel="stylesheet" href="{{asset('css/3area/city-picker.css')}}">
                        <script src="{{asset('js/3area/city-picker.data.js')}}"></script>
                        <script src="{{asset('js/3area/city-picker.js')}}"></script>
                        <script src="{{asset('js/3area/main.js')}}"></script>
                        <td>
                            <div class="docs-methods" style="display: inline-block">
                                <form class="form-inline">
                                    <div id="distpicker">
                                        <div class="form-group">
                                            <div style="position: relative;">
                                                <input id="city-picker3" class="self-form" readonly type="text" value="江苏省/南京市/浦口区" data-toggle="city-picker">
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
                    <a href="javascript:"onclick="add()" class="fr sp_button">添加进审批表</a>
                </div>
            </div>
            <!--快捷导航 结束-->
        </div>
        <div class="result_wrap">
            <div class="result_content">
                <table class="list_tab">
                    <tr>
                        {{--<th class="tc">ID</th>--}}
                        <th width="50">选择</th>
                        <th class="tc">ID</th>
                        <th>方案名</th>
                        <th>地区</th>
                        <th>车型</th>
                        <th>文件类型</th>
                        <th>最后修改时间</th>
                        <th>管理员</th>
                        <th>操作（管理员）</th>
                    </tr>
                    <div style="display: none">{{$num=1}}</div>
                    @foreach($data as $v)
                    <tr>
                        <td onclick="checkboxBug(this)" class="style-center">
                            <input type="checkbox" name="id" value="{{$v->id}}" style="display: none;">
                            <a href="#" class="check-false" onclick="return false">□</a>
                        </td>
                        <td class="tc">{{$num++}}</td>
                        <td>
                            {{$v['name']}}
                        </td>
                        <td>
                            {{$v->area}}
                        </td>
                        <td>
                            {{$v->cartype}}
                        </td>
                        <td>
                            {{$v->fileid}}
                        </td>
                        <td>
                            {{$v->updated_at}}
                        </td>
                        <td>
                            <span class="sp_person">{{$v->filemanager}}</span>
                        </td>
                        <td>
                            <a href="{{url('admin/JC/'.$v->id.'/edit')}}">修改</a>
                            <a href="javascript:"onclick="deleteObj({{$v->id}})">删除</a>
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
        //删除分类
        function deleteObj(id){
            layer.confirm('确定删除这位仁兄？', {
                btn: ['确定','取消'] //按钮
            }, function(){
                $.post("{{url('admin/JC/')}}/"+id,{'_method':'delete','_token':"{{csrf_token()}}"},function(data){
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
        function searchName(){
            var val = $('#search').val();

            $.post("{{url('admin/kao/search')}}",{name:val,'_token':'{{csrf_token()}}'},function(data){
                $('tr:gt(0)').remove();
                $(data).each(function(k,v){
                    var url1 ="kao/"+v.kao_id+"/edit";
                    var url2 = 'javascript:onclick=deleteObj('+v.kao_id+')';
                    if(v.kao_if==1){
                        v.kao_if="提交";
                    }else {
                        v.kao_if="未提交";
                    }
                    $('tr:first').after("<tr><td class='tc'>"+v.kao_id+"</td>" +
                            "<td>"+v.kao_name+"</td>" +
                            "<td>"+v.kao_if+"</td>" +
                            "<td><a href='"+url1+"'>修改</a><a href="+url2+">删除</a></td></tr>");
                })
            });
        }
        //todo checkbox的自定义样式
        function checkboxBug(obj) {
            //因为checkbox有全选的bug，所以用了其他方法
            //todo 改变目标checkbox状态
            var flag = $(obj).children('input').attr('checked')
            $(obj).children('input').attr('checked',!flag)

            //todo 改变文字的状态
            if (!flag){
                $(obj).children('a').html('√').removeClass().addClass('check-success');
            }else{
                $(obj).children('a').html('□').removeClass().addClass('check-false');
            }
        }

        //todo 添加进审批表
        /**
         * ajax传参：id与部门大类 2个参数
        * */
        function add() {
            var val = [];
            $('input[type="checkbox"]:checked').each(function (k,v) {
                val[k] = $(this).val()
            });

            var filehome = '集成方案/'+"{{session('filetype')}}"

            $.post("{{url('sub/add')}}",{id:val,model:"JC",filehome:filehome,'_token':"{{csrf_token()}}"},function (data) {
                if (data.status == 0 ){
                    layer.msg(data.msg, {icon: 6});
                    setTimeout(function(){
                        location.href = location.href;
                    },900)
                }else if(data.status == 1){
                    layer.msg(data.msg, {icon: 5});
                    setTimeout(function(){
                        location.href = location.href;
                    },900)
                }
            })
        }
    </script>
@endsection
