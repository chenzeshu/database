@extends('layouts.admin')
@section('content')
	<!--头部 开始-->
	<div class="top_box">
		<div class="top_left">
			<div class="logo">数据库页面</div>
			<ul>
				<li><a href="{{url('admin/index')}}">数据文档表</a></li>
				<li><a href="{{url('sub/index')}}" class="active">我的审批表</a></li>
				<li class="info-wrapper"><a href="{{url('approve/index')}}">待审批申请（管理员）</a>
					@if($num)
					<span class="info">{{$num}}</span>
						@endif
				</li>
			</ul>
		</div>

		<div class="top_right">
			<ul>
				<li>你好：{{\Illuminate\Support\Facades\Session::get('user_name')}}</li>
				<li><a href="{{url('approve/register')}}" target="main">注册用户</a></li>
				<li><a href="{{url('sub/pass')}}" target="main">修改密码</a></li>
				<li><a href="{{url('admin/logout')}}">退出</a></li>
			</ul>
		</div>
	</div>
	<!--头部 结束-->

	<!--左侧导航 开始-->
	<div class="menu_box">
		<ul>
			<li>
				<h3><i class="fa fa-fw fa-clipboard"></i>我的审批表</h3>
				<ul class="sub_menu">
					<li><a href="{{url('sub/subtable')}}" target="main"><i class="fa fa-fw fa-plus-square"></i>临时审批表</a></li>
					<li><a href="{{url('sub/history')}}" target="main"><i class="fa fa-fw fa-plus-square"></i>提交历史</a></li>
				</ul>
			</li>
        </ul>
	</div>
	<!--左侧导航 结束-->

	<!--主体部分 开始-->
	<div class="main_box">
		<iframe src="{{url('sub/subtable')}}" frameborder="0" width="100%" height="100%" name="main"></iframe>
	</div>
	<!--主体部分 结束-->

	<!--底部 开始-->
	<div class="bottom_box">
		CopyRight © 2016. Powered By <a href="http://www.jianshu.com/users/adc147f1ec89/latest_articles">http://www.chenzeshu.com</a>.
	</div>
	<!--底部 结束-->
@endsection
