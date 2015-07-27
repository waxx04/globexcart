<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'HomeController@index');

Route::get('home', 'HomeController@index');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

Route::get('login', function() {
	return view('pages.login');
});

Route::get('products/all-products', 'ProductController@allproducts');
Route::get('search', 'ProductController@search');
Route::get('products/sub-categories', 'ProductController@subcats');
Route::get('products/post-sub-cats', 'ProductController@postsubcats');

Route::get('cart', function() {
	return view('pages.cart');
});

Route::get('register', function() {
	return view('pages.register');
});

Route::get('adpost', function() {
	return view('pages.adpost');
});

Route::get('admin', function() {
	return 'ok';
});

Route::resource('products', 'ProductController');

Route::get('admin/{page}', 'AdminController@recieve');

Route::get('test', function() {
	return view('pages.test');
});

