<?php

use Illuminate\Support\Facades\Route;

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

// Route::get('/home', 'HomeController@index')->name('home');
Route::group([
    'prefix' => 'admin',
    'namespace' => 'Auth'
], function () {
    Route::get('/', 'LoginController@showLoginForm');
    Route::get('/login', 'LoginController@showLoginForm');
    Route::post('/login', 'LoginController@login');
    Route::get('/logout', 'LoginController@logout');
});	

Route::group([
    'prefix' => 'admin',
    'namespace' => 'Admin'
    // 'middleware' => 'admin'
], function () {
	Route::get('/dashboard','UserController@index')->name('admin.dashboard');
	Route::get('/list','UserController@index1')->name('admin.dashboard');
	Route::get('/profile','UserController@getProfile');
	Route::post('/profile','UserController@postProfile');

	Route::get('/product_new','UserController@getNews');
	// Route::post('/product_new','UserController@postNews');

	Route::get('/product_new/add','UserController@getAdd');
	Route::post('/product_new/add','UserController@postAdd');
	Route::get('/product_new/edit/{id}','UserController@getEdit');
	Route::post('/product_new/edit/{id}','UserController@postEdit');
	Route::get('/product_new/delete/{id}','UserController@getDelete');

	Route::get('/product_old','UserController@getOld');
	Route::get('/product_old/add','UserController@getOldAdd');
	Route::post('/product_old/add','UserController@postOldAdd');
	Route::get('/product_old/edit/{id}','UserController@getOldEdit');
	Route::post('/product_old/edit/{id}','UserController@postOldEdit');
	Route::get('/product_old/delete/{id}','UserController@Delete');

	Route::get('/type_product','UserController@getType');
	Route::get('/type_product/add','UserController@getTypeAdd');
	Route::post('/type_product/add','UserController@getTypePost');
	Route::get('/type_product/edit/{id}','UserController@getTypeEdit');
	Route::post('/type_product/edit/{id}','UserController@TypePost');
	Route::get('/type_product/delete/{id}','UserController@getTypeDelete');

});
Route::group([
    'namespace' => 'Frontend',
], function () {
	Route::get('index',[
	'as'=>'trang-chu',
	'uses'=>'PageController@getIndex'
	]);
	Route::get('loai-san-pham/{type}',[
		'as'=>'loaisanpham',
		'uses'=>'PageController@getLoaiSp'
	]);
	Route::get('chi-tiet-san-pham/{id}',[
		'as'=>'chitietsanpham',
		'uses'=>'PageController@getChitiet'
	]);
	Route::get('lien-he',[
		'as'=>'lienhe',
		'uses'=>'PageController@getLienhe'
	]);
	Route::get('add-to-cart/{id}',[
		'as'=>'themgiohang',
		'uses'=>'PageController@getAddtoCart'
	]);
	Route::get('del-cart/{id_delete}',[
		'as'=>'xoagiohang',
		'uses'=>'PageController@getDelete'
	]);
	Route::get('dat-hang',[
		'as'=>'dathang',
		'uses'=>'PageController@getCheckout'
	]);
	Route::post('dat-hang',[
		'as'=>'dathang',
		'uses'=>'PageController@postCheckout'
	]);
	Route::get('dang-nhap',[
		'as'=>'login_member',
		'uses'=>'PageController@getLogin'
	]);
	Route::post('dang-nhap',[
		'as'=>'login_member',
		'uses'=>'PageController@postLogin'
	]);

	Route::get('dang-ki',[
		'as'=>'signin_member',
		'uses'=>'PageController@getSignin'
	]);

	Route::post('dang-ki',[
		'as'=>'signin_member',
		'uses'=>'PageController@postSignin'
	]);
	Route::get('dang-xuat',[
		'as'=>'logout_member',
		'uses'=>'PageController@postLogout'
	]);
	Route::get('search',[
		'as'=>'search',
		'uses'=>'PageController@getSearch'
	]);
});


