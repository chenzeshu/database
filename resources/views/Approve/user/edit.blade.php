@extends('layouts/admin')
@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <i class="fa fa-home"></i> <a href="{{url('approve/user').'/'.session('fileid')}}">首页</a> &raquo; <a href="#">{{session('filetype')}}</a>
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
            <h3>编辑用户信息</h3>
        </div>
        <div class="result_content">
            <div class="short_wrap">
                <a href="{{url('approve/register')}}"><i class="fa fa-plus"></i>添加用户</a>
            </div>
        </div>
    </div>
    <!--结果集标题与导航组件 结束-->

    <div class="result_wrap">
        <form action="{{url('approve/user/'.$data->id)}}" method="post">
            <input type="hidden" name="_method" value="put">
            {{csrf_field()}}
            <table class="add_tab">
                <tbody>
                <tr>
                    <th><i class="require">*</i>用户登录id：</th>
                    <td><input type="text" name="name" value="{{$data->name}}"></td>
                </tr>
                <tr>
                    <th><i class="require">*</i>真实姓名：</th>
                    <td><input type="text" name="kittyname" value="{{$data->kittyname}}"></td>
                </tr>
                {{--<tr>--}}
                    {{--<th width="120"><i class="require">*</i>用户密码：</th>--}}
                    {{--<td>--}}
                        {{--<input type="password" name="password" value=""> </i>6-20位，请输入密码</span>--}}
                    {{--</td>--}}
                {{--</tr>--}}
                {{--<tr>--}}
                    {{--<th><i class="require">*</i>确认密码：</th>--}}
                    {{--<td>--}}
                        {{--<input type="password" name="password_confirmation"> </i>再次输入密码</span>--}}
                    {{--</td>--}}
                {{--</tr>--}}
                <tr>
                    <th>角色权限</th>
                    <td>
                        <select name="" id="" class="sel_button">
                            <option value="">暂时留白</option>
                            <option value="">普通用户</option>
                            <option value="">管理员</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th>邮箱</th>
                    <td><input type="text" name="email" value="{{$data->email}}"></td>
                </tr>
                <tr>
                    <th>手机号码</th>
                    <td><input type="text" name="phone" value="{{$data->phone}}"></td>
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