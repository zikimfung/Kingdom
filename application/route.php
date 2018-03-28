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
////Website
use	think\Route;
Route::domain('http://192.168.2.110:804','index');
/////PC
Route::rule('/works','index/works');
Route::rule('/worksinfo/:id','index/index/worksinfo');
Route::rule('/area','index/area');
Route::rule('/areainfo/:id','index/index/areainfo');
Route::rule('/GetOtherPosts','index/index/GetOtherPosts');
return [
    '__pattern__' => [
        'name' => '\w+',
    ],
    '[hello]'     => [
        ':id'   => ['index/hello', ['method' => 'get'], ['id' => '\d+']],
        ':name' => ['index/hello', ['method' => 'post']],
    ],

];
