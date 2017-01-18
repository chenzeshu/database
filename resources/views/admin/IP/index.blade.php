@extends('layouts/admin')
@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/PR').'/'.session('fileid')}}">首页</a> &raquo; <a href="#">知识产权</a>
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
                    <a href="{{url('admin/IP/create')}}"><i class="fa fa-plus"></i>添加{{session('filetype')}}</a>
                    <input type="text" name="kao_name" class="xs" placeholder="填写证书名称" id="search">
                    <input type="button" value="查找" onclick="search()">
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
                        <th>证书名</th>
                        <th class="else-hook">专利号/申请号/商标号</th>
                        <th class="honor-hook">相关产品</th>
                        <th class="honor-hook">发放单位</th>
                        <th class="honor-hook">发放时间</th>
                        <th>最后修改时间</th>
                        <th>管理员</th>
                        <th>操作（管理员）</th>
                    </tr>
                    <div style="display: none">{{$num=1}}</div>
                    @foreach($data as $v)
                    <tr>
                        <td onclick="checkboxBug(this)" class="style-center">
                            <input type="checkbox" name="id" value="{{$v->id}}" style="display: none;">
                            {{--提交购物车=传上checked的id+fileid的小数组，小数组整合成一个二维数组--}}
                            <a href="#" class="check-false" onclick="return false">□</a>
                        </td>
                        <td class="tc">{{$num++}}</td>
                        <td>
                            {{$v['name']}}
                        </td>
                        <td class="else-hook">
                            {{$v->number}}
                        </td>
                        <td class="honor-hook">{{$v->relation}}</td>
                        <td class="honor-hook">{{$v->issue_unit}}</td>
                        <td class="honor-hook">{{$v->issue_time}}</td>
                        <td>
                            {{$v->updated_at}}
                        </td>
                        <td>
                            <span class="sp_person">{{$v->filemanager}}</span>
                        </td>
                        <td>
                            <a href="{{url('admin/IP/'.$v->id.'/edit')}}">修改</a>
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
        function deleteObj(id) {
            layer.confirm('确定删除这位仁兄？', {
                btn: ['确定', '取消'] //按钮
            }, function () {
                $.post("{{url('admin/IP/')}}/" + id, {
                    '_method': 'delete',
                    '_token': "{{csrf_token()}}"
                }, function (data) {
                    if (data.status == '0') {
                        layer.msg(data.msg, {icon: 6});
                        setTimeout(function () {
                            location.href = location.href;
                        }, 900)
                    } else if (data.status == '1') {
                        layer.msg(data.msg, {icon: 5});
                        setTimeout(function () {
                            location.href = location.href;
                        }, 900)
                    } else {
                        layer.msg(data.msg, {icon: 5});
                        setTimeout(function () {
                            location.href = location.href;
                        }, 900)
                    }
                });
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

        //todo 荣誉证书展现--自执行
        (function showhonor() {
            if ("{{session('fileid')}}" == 5){
                $('.honor-hook').show()
                $('.else-hook').hide()
            }else{
                $('.honor-hook').hide()
            }
        })()

        //todo 添加进审批表
        /**
         * ajax传参：id与部门大类 2个参数
         * */
        function add() {
            var val = [];
            $('input[type="checkbox"]:checked').each(function (k,v) {
                val[k] = $(this).val()
            });

            var filehome = '知识产权/'+"{{session('filetype')}}"

            $.post("{{url('sub/add')}}",{id:val,model:"IP",filehome:filehome,'_token':"{{csrf_token()}}"},function (data) {
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

        function search() {
            var name = $('#search').val();
            var url = "{{url('admin/IPsearch')}}";
            var data = {
                '_token':"{{csrf_token()}}",
                name:name
            }

            $.post(url,data,function (data) {
                $('tr:gt(0)').remove()

                $(data).each(function (k,v) {
                    var editurl = "{{url('admin/IP/')}}/"+v.id+'/edit'
                    $('tr:last').after('<tr><td onclick="checkboxBug(this)" class="style-center">' +
                            '<input type="checkbox" name="id" value="'+v.id+'" style="display: none;">' +
                            '<a href="#" class="check-false" onclick="return false">□</a></td>' +
                            '<td class="tc">'+(k+1)+'</td>' +
                            '<td>'+v.name+'</td>' +
                            '<td>'+v.number+'</td>' +
                            '<td>'+v.updated_at+'</td>' +
                            '<td>'+v.filemanager+'</td>' +
                            '<td><a href="'+editurl+'">修改</a>' +
                            '<a href="javascript:onclick=deleteObj('+v.id+')">删除</a></td></tr>')
                })
            })
        }
    </script>
@endsection
