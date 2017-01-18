@extends('layouts/admin')
@section('content')

    {{--额外引用CSS文件--}}
    <link rel="stylesheet" href="{{asset('css/animation.css')}}">
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/PR').'/'.session('fileid')}}">首页</a> &raquo; <a href="#">项目管理</a>
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
                    <a href="{{url('admin/PRO/create')}}"><i class="fa fa-plus"></i>添加{{session('filetype')}}</a>
                    <input type="text" name="name" class="xs" placeholder="填写文档名称">
                    <input type="text" name="profession" class="xs" placeholder="填写行业">
                    <input type="text" name="area" class="xs" placeholder="填写区域">
                    <input type="text" name="PM" class="xs" placeholder="填写项目经理">
                    <input type="text" name="sum" class="xs" placeholder="填写金额（元）">
                    <input placeholder="合同生效日期" name="validtime" class="laydate-icon" onclick="laydate()">
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
                        <th>文件名</th>
                        <th>行业</th>
                        <th>区域</th>
                        <th>项目经理</th>
                        <th>金额</th>
                        <th>合同生效时间</th>
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
                            {{$v->profession}}
                        </td>
                        <td>
                            {{$v->area}}
                        </td>
                        <td>
                            {{$v->PM}}
                        </td>
                        <td>
                            {{$v->sum}}
                        </td>
                        <td>
                           {{date('Y-m-d', (int)$v->valid_time)}}
                        </td>
                        <td>
                            {{$v->updated_at}}
                        </td>
                        <td>
                            <span class="sp_person">{{$v->filemanager}}</span>
                        </td>
                        <td>
                            <a href="{{url('admin/PRO/'.$v->id.'/edit')}}">修改</a>
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
                $.post("{{url('admin/PRO/')}}/"+id,{'_method':'delete','_token':"{{csrf_token()}}"},function(data){
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
            var filehome = '项目管理/'+"{{session('filetype')}}";

            $.post("{{url('sub/add')}}",{id:val,model:"Program",filehome:filehome,'_token':"{{csrf_token()}}"},function (data) {
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

        function addZero(obj) {
            if (typeof(obj) === 'number'){
                obj = obj.toString()
            }
            if(obj.length==1) {
                return '0' + obj + ''
            }
            return obj;
        }
        function search() {
            var name =  $('input[name="name"]').val()
            var profession = $('input[name="profession"]').val()
            var area =  $('input[name="area"]').val()
            var PM =  $('input[name="PM"]').val()
            var sum =  $('input[name="sum"]').val()
            var validtime =  $('input[name="validtime"]').val()
            var url = "{{url('admin/PROsearch')}}";
            if(!validtime) {
                var mytime = new Date()
                validtime = mytime.toLocaleDateString()
            }
            var data = {
                '_token':"{{csrf_token()}}",
                name:name,
                profession:profession,
                area:area,
                PM:PM,
                sum:sum,
                validtime:validtime
            }

            $.post(url,data,function (data) {
                $('tr:gt(0)').remove()

                $(data).each(function (k,v) {
                    var editurl = "{{url('admin/program/')}}/"+v.id+'/edit'
                    var time = new Date(v.valid_time*1000)
                    var year = time.getFullYear()
                    var date = time.getDate()
                    var month = time.getMonth()+1

                    $('tr:last').after('<tr><td onclick="checkboxBug(this)" class="style-center">' +
                            '<input type="checkbox" name="id" value="'+v.id+'" style="display: none;">' +
                            '<a href="#" class="check-false" onclick="return false">□</a></td>' +
                            '<td class="tc">'+(k+1)+'</td>' +
                            '<td>'+v.name+'</td>' +
                            '<td>'+v.profession+'</td>' +
                            '<td>'+v.area+'</td>' +
                            '<td>'+v.PM+'</td>' +
                            '<td>'+v.sum+'</td>' +
                            '<td>'+year+'-'+addZero(month)+'-'+addZero(date)+'</td>' +
                            '<td>'+v.updated_at+'</td>' +
                            '<td>'+v.filemanager+'</td>' +
                            '<td><a href="'+editurl+'">修改</a>' +
                            '<a href="javascript:onclick=deleteObj('+v.id+')">删除</a></td></tr>')
                })
            })
         }
    </script>
@endsection
