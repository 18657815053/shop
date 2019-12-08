<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

use think\Route;

//Route::rule('路由表达式','路由地址','请求类型','路由参数(数组)','变量规则(数组)');
//请求类型 GET POST DELETE PUT *
//路由参数 参考官方文档
Route::rule('/', 'api/Index/index');
//Route::get('test', 'sample/Test/test');
//version 版本号
Route::rule('api/:version/banner/:id', 'api/:version.Banner/getBanner', 'get');//轮播图

Route::rule('api/:version/theme', 'api/:version.Theme/getSimpleList', 'get');//专题列表
Route::rule('api/:version/theme/:id', 'api/:version.Theme/getComplexOne', 'get');//一个专题的所有信息

Route::rule('api/:version/product/recent', 'api/:version.Product/getRecent', 'get');//获取最近新品
Route::rule('api/:version/product/by_category/:id', 'api/:version.Product/getAllInCategory', 'get');//根据分类获取商品
Route::rule('api/:version/product/:id', 'api/:version.Product/getOne', 'get', '', ['id' => '\d+']);//获取一条商品信息


Route::rule('api/:version/category/all', 'api/:version.Category/getAllCategory', 'get');//所有分类

Route::rule('api/:version/token/user', 'api/:version.Token/getToken', 'post');//获取Token令牌

Route::rule('api/:version/address', 'api/:version.Address/createOrUpdateAddress', 'post');//新增或修改用户地址

Route::rule('api/:version/order', 'api/:version.Order/placeOrder', 'post');//用户下单
