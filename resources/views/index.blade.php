@extends('layouts.admin')
@section('content')
	<!--头部 开始-->
	<div class="top_box">
		<div class="top_left">
			<div class="logo">数据库页面</div>
			<ul>
				<li><a href="#" class="">数据文档表</a></li>
				<li><a href="{{url('sub/index')}}">我的审批表</a></li>
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
				<h3><i class="fa fa-fw fa-clipboard"></i>人事档案</h3>
				<ul class="sub_menu">
					<li><a href="{{url('admin/PR/index/1')}}" target="main"><i class="fa fa-fw fa-plus-square"></i>个人证件照</a></li>
					<li><a href="{{url('admin/PR/index/2')}}" target="main"><i class="fa fa-fw fa-plus-square"></i>身份证</a></li>
					<li><a href="{{url('admin/PR/index/3')}}" target="main"><i class="fa fa-fw fa-plus-square"></i>学历学位</a></li>
					<li><a href="{{url('admin/PR/index/4')}}" target="main"><i class="fa fa-fw fa-plus-square"></i>职称证书</a></li>
					<li><a href="{{url('admin/PR/index/5')}}" target="main"><i class="fa fa-fw fa-plus-square"></i>培训证书</a></li>
				</ul>
			</li>
			<li>
				<h3><i class="fa fa-fw fa-clipboard"></i>项目管理</h3>
				<ul class="sub_menu">
					<li><a href="{{url('admin/PRO/index/1')}}" target="main"><i class="fa fa-fw fa-plus-square"></i>中标通知书</a></li>
					<li><a href="{{url('admin/PRO/index/2')}}" target="main"><i class="fa fa-fw fa-plus-square"></i>验收报告</a></li>
					<li><a href="{{url('admin/PRO/index/3')}}" target="main"><i class="fa fa-fw fa-plus-square"></i>感谢信</a></li>
					<li><a href="{{url('admin/PRO/index/4')}}" target="main"><i class="fa fa-fw fa-plus-square"></i>合同</a></li>
					<li><a href="{{url('admin/PRO/index/5')}}" target="main"><i class="fa fa-fw fa-plus-square"></i>招标文件</a></li>
					<li><a href="{{url('admin/PRO/index/6')}}" target="main"><i class="fa fa-fw fa-plus-square"></i>投标文件</a></li>
					<li><a href="{{url('admin/PRO/index/7')}}" target="main"><i class="fa fa-fw fa-plus-square"></i>变更资料</a></li>
					<li><a href="{{url('admin/PRO/index/8')}}" target="main"><i class="fa fa-fw fa-plus-square"></i>资质</a></li>
				</ul>
			</li>
			<li>
				<h3><i class="fa fa-fw fa-clipboard"></i>质检</h3>
				<ul class="sub_menu">
					<li><a href="{{url('admin/QT/index/1')}}" target="main"
						   title="本公司的产品第三方检测报告" style="text-overflow: ellipsis;white-space:nowrap;overflow: hidden"><i class="fa fa-fw fa-plus-square"></i>本公司的产品第三方检测报告</a></li>
					<li><a href="{{url('admin/QT/index/2')}}" target="main"
						   title="供方产品第三方产品检测报告" style="text-overflow: ellipsis;white-space:nowrap;overflow: hidden"><i class="fa fa-fw fa-plus-square"></i>供方产品第三方产品检测报告</a></li>
					<li><a href="{{url('admin/QT/index/3')}}" target="main"
						   title="按项目保存改装厂出厂验出资料" style="text-overflow: ellipsis;white-space:nowrap;overflow: hidden"><i class="fa fa-fw fa-plus-square"></i>按项目保存改装厂出厂验出资料</a></li>
					<li><a href="{{url('admin/QT/index/4')}}" target="main"
						   title="系统集成项目出厂验收文件" style="text-overflow: ellipsis;white-space:nowrap;overflow: hidden"><i class="fa fa-fw fa-plus-square"></i>系统集成项目出厂验收文件</a></li>
					<li><a href="{{url('admin/QT/index/5')}}" target="main"><i class="fa fa-fw fa-plus-square"></i>产品标准</a></li>
					<li><a href="{{url('admin/QT/index/6')}}" target="main"
						   title="对外可开展合作业务证明" style="text-overflow: ellipsis;white-space:nowrap;overflow: hidden"><i class="fa fa-fw fa-plus-square"></i>对外可开展合作业务证明</a></li>
					<li><a href="{{url('admin/QT/index/7')}}" target="main"><i class="fa fa-fw fa-plus-square"></i>培训证书</a></li>
					<li><a href="{{url('admin/QT/index/8')}}" target="main"><i class="fa fa-fw fa-plus-square"></i>仪器计量证书</a></li>
				</ul>
			</li>
			<li>
				<h3><i class="fa fa-fw fa-clipboard"></i>知识产权</h3>
				<ul class="sub_menu">
					<li><a href="{{url('admin/IP/index/1')}}" target="main"><i class="fa fa-fw fa-plus-square"></i>专利证书</a></li>
					<li><a href="{{url('admin/IP/index/2')}}" target="main"><i class="fa fa-fw fa-plus-square"></i>专利受理通知书</a></li>
					<li><a href="{{url('admin/IP/index/3')}}" target="main"><i class="fa fa-fw fa-plus-square"></i>商标证书</a></li>
					<li><a href="{{url('admin/IP/index/4')}}" target="main"><i class="fa fa-fw fa-plus-square"></i>软件著作权证书</a></li>
					<li><a href="{{url('admin/IP/index/5')}}" target="main"><i class="fa fa-fw fa-plus-square"></i>荣誉证书</a></li>
				</ul>
			</li>
            <li>
            	<h3><i class="fa fa-fw fa-clipboard"></i>集成规划所</h3>
                <ul class="sub_menu">
					<li><a href="{{url('admin/JCP')}}" target="main"><i class="fa fa-fw fa-plus-square"></i>行业管理</a></li>
                    <li><a href="#"><i class="fa fa-fw fa-plus-square"></i>集成方案平台</a></li>
                </ul>
            </li>
        </ul>
	</div>
	<!--左侧导航 结束-->

	<!--主体部分 开始-->
	<div class="main_box">
		<iframe src="{{url('admin/PR/index/1')}}" frameborder="0" width="100%" height="100%" name="main"></iframe>
	</div>
	<!--主体部分 结束-->

	<!--底部 开始-->
	<div class="bottom_box">
		CopyRight © 2016. Powered By <a href="http://www.jianshu.com/users/adc147f1ec89/latest_articles">http://www.chenzeshu.com</a>.
	</div>
	<!--底部 结束-->
@endsection
