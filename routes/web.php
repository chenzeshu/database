<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

//非验证页面
Route::group(['prefix'=>'admin','namespace' => 'Admin'], function () {
    //登录界面（首页1）
    Route::any('login', 'LoginController@login');
    Route::any('code', 'LoginController@code');
    //注册放在approve里
    //修改密码放在sub里
    //登出
    Route::get('logout', 'LoginController@logout');
    //测试
    Route::any('test/{name?}', 'LoginController@test');
});


//todo response 下载法，a标签所有浏览器全部兼容，而不是a标签加download属性
Route::group(['middleware'=>['admin.login'],'namespace' => 'Download'],function (){
    Route::any('download/{url?}','IndexController@index');
});


//数据页 admin
Route::group(['middleware'=>['admin.login'],'prefix'=>'admin','namespace' => 'Admin'], function () {
    //主界面（首页1）
    Route::any('index', 'IndexController@index');

    /**
     *  人事档案
     *  个人证件照  fileid=1
     *  身份证     fileid=2
     *  学历学位   fileid=3
     *  职称证书   fileid=4
     *  培训证书   fileid=5
     */
    Route::get('PR/index/{fileid}', 'PRController@index');
    Route::resource('PR', 'PRController');
    Route::any('PRsearch','PRController@search');

    //上传方法
    Route::any('uploadfile/{department}/{fileid}/{profession?}', 'CommonController@uploadfile');
    /**
     *  项目管理
     *  中标通知书  fileid=1
     *  验收报告    fileid=2
     *  感谢信      fileid=3
     *  合同        fileid=4
     *  招标文件    fileid=5
     *  投标文件    fileid=6
     *  变更资料    fileid=7
     *  资质       fileid=8
     */
    Route::get('PRO/index/{fileid}', 'ProgramController@index');
    Route::resource('PRO', 'ProgramController');
    Route::any('PROsearch', 'ProgramController@search');

    //上传方法
//    Route::any('upload1', 'CommonController@upload1');
    /**
     *  项目管理
     *  本公司产品第三方检测报告   fileid=1
     *  供方产品第三方检测报告       fileid=2
     *  按项目保存改装厂出厂验出资料   fileid=3
     *  统集成项目出厂验收文件       fileid=4
     *  产品标准                  fileid=5
     *  对外可开展合作业务证明    fileid=6
     *  培训证书               fileid=7
     *  仪器计量证书          fileid=8
     */
    Route::get('QT/index/{fileid}', 'QTController@index');

    Route::resource('QT', 'QTController');
    Route::any('QTsearch', 'QTController@search');
    //上传方法
//    Route::any('upload2', 'CommonController@upload2');
    /**
     *  知识产权
     *  专利证书        fileid=1
     *  专利受理通知书    fileid=2
     *  商标证书           fileid=3
     *  软件著作权证书       fileid=4
     *  荣誉证书              fileid=5
     */
    Route::get('IP/index/{fileid}', 'IPController@index');
    Route::resource('IP', 'IPController');
    Route::any('IPsearch', 'IPController@search');
    //上传方法
//    Route::any('upload3', 'CommonController@upload3');

    /**
     *  集成规划所_行业维护
     *
     *  行业与JC表中的fileid关系见此表
     */
    Route::resource('JCP', 'JCPController');
    /**
     *  集成规划所
     *
     *  行业与JC表中的fileid关系见JCP表
     */
    Route::get('JC/index/{professionid}', 'JCController@index');
    Route::resource('JC', 'JCController');
    Route::any('JCsearch', 'JCController@search');
    //上传方法
//    Route::any('upload4', 'CommonController@upload4');
});

//审批表 sub
Route::group(['middleware'=>['admin.login'],'prefix'=>'sub','namespace' => 'Sub'],function (){
   //对应 index2.blade.php
    Route::any('index','IndexController@index');
   //我的审批表历史
    Route::any('history','IndexController@history');
    Route::any('readhistory/{tablename}','IndexController@readHistory');  //细节
   //我的审批表
    Route::any('subtable','IndexController@subTable');
   //添加进审批表
    Route::any('add','IndexController@add');

    //修改密码
    Route::any('pass','IndexController@pass');

    //todo 个人审批表的resource功能补完
    Route::resource('self','IndexController');

});

//管理员履行审批职责
Route::group(['middleware'=>['admin.login'],'prefix'=>'approve','namespace' => 'Approve'],function (){
    /**
     * 目前管理员：高晓峰、钱正宇
     */
    //对应index3
    Route::any('index','IndexController@index');
    //审批职责表
    Route::any('approve','IndexController@approve');  //审批主页
    Route::get('readtable/{tablename}','IndexController@readTable');
    Route::any('pass/{id}','IndexController@passTable');
    Route::any('rej/{id}','IndexController@rejTable');
    Route::any('approvestatus/{option}','IndexController@approveStatus');
    //用户提交审核
    Route::any('submit','IndexController@submit');
    //注册用户
    Route::any('register','IndexController@register');
    //用户管理
    Route::resource('user','UserController');
    //返回未通过原因
    Route::any('showinfo/{id}','IndexController@showInfo');
});

