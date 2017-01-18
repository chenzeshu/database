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
                <h3 class="personal-title">临时{{session('filetype')}}</h3>
                <div class="personal-state-wrapper state1">
                    <span class="personal-state">未提交</span>
                </div>
            </div>
            <!--快捷导航 开始-->
            <div class="result_content">
                <div class="short_wrap">
                    <input type="text" name="watermark" class="lg" placeholder="填写水印" id="watermark">
                    <select name="" id="" class="destination-hook" onchange="showWatermark()">
                        <option value="">用途</option>
                        <option value="投标">投标(钱正宇)</option>
                        <option value="报项目用">报项目用(高晓峰)</option>
                        <option value="资质维护">资质维护(高晓峰)</option>
                        <option value="项目合作">项目合作(高晓峰)</option>
                        <option value="其他">其他(高晓峰)</option>
                    </select>
                    <input type="button" value="提交" onclick="subApprove()">
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
                        <th>文件名</th>
                        <th>文件归属</th>
                        <th class="else-hook">下载（测试先提供链接）</th>
                        <th>下载次数</th>
                        <th>最后修改时间</th>
                        <th>操作</th>
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
                        <td class="else-hook">
                            {{$v->filepath}}
                        </td>
                        <td></td>
                        <td>
                            {{$v->updated_at}}
                        </td>
                        <td>
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
        $(function () {
            init();
        })

        function init() {
            showWatermark();
        }

        //删除分类
        function deleteObj(id){
            layer.confirm('确定删除这位仁兄？', {
                btn: ['确定','取消'] //按钮
            }, function(){
                $.post("{{url('sub/self/')}}/"+id,{'_method':'delete','_token':"{{csrf_token()}}"},function(data){
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

        function showWatermark() {
            var val = $('.destination-hook option:selected').val()
            if (val == "其他" ){
                $('#watermark').show();
            }else{
                $('#watermark').hide();
            }
        }
//        todo 提交审核
        function subApprove() {
            //todo 组装数据
              //申请人
                var person = "{{session('user_name')}}"
              //水印
                var val = $('.destination-hook option:selected').val();
                var watermark = '';
                switch(val){
                    case "其他":
                        let water = $('#watermark').val()
                        if (water){
                            watermark = water;
                        }else {
                            alert('水印不可为空！');
                            return;
                        }
                        break;
                    case "":
                        alert('水印不可为空！');
                            return;
                        break;
                    default:
                        watermark = val;
                        break;
                }
              //表名(前端做好，减少后端运算)
                var tablename = "{{session('user_name')}}"+"_subtable";

            //todo 引入layer
            //prompt层
            layer.prompt({title: '请为你的审批表取个名', formType: 3}, function(name, index){
                layer.close(index);

                //todo 组装成对象方便维护
                var data={
                    name:name,
                    person:person,
                    watermark:watermark,
                    tablename:tablename,
                    "_token":"{{csrf_token()}}"
                }

                layer.confirm('提交后，你的临时审批表会被清空',{
                    btn: ['确定','取消']
                },function () {
                    $.post("{{url('approve/submit')}}",data,function (data) {
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
                })
            });
        }



    </script>
@endsection
