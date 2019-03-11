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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::group(['prefix' => 'admin','namespace' => 'Admin'],function ($router)
{
    $router->get('login', 'LoginController@showLogin')->name('admin.login');
    $router->post('login', 'LoginController@login');
    $router->post('logout', 'LoginController@logout');

//    $router->get('index', 'AdminController@index');
});
//Route::group(['prefix' => 'admin','namespace' => 'Admin','middleware'=>'auth.admin'],function ($router)
Route::group(['prefix' => 'admin','namespace' => 'Admin'],function ($router)
{
    $router->get('index', 'AdminController@index');
    //后台用户管理
    Route::resource('manager','ManagerController');
    //角色管理
    Route::resource('role','RoleController');
    //权限管理
    Route::resource('permission','PermissionController');
});