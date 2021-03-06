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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('admin', 'Admin\AdminController@index');
Route::resource('admin/roles', 'Admin\RolesController');
Route::resource('admin/permissions', 'Admin\PermissionsController');
Route::resource('admin/users', 'Admin\UsersController');
Route::get('admin/generator', ['uses' => '\Appzcoder\LaravelAdmin\Controllers\ProcessController@getGenerator']);
Route::post('admin/generator', ['uses' => '\Appzcoder\LaravelAdmin\Controllers\ProcessController@postGenerator']);
Route::resource('frontendprofile/profiles', 'Profile\\ProfilesController');
Route::get('temp', 'Weather\WeatherController@index');


Route::get('get-location-from-ip',function(){
    $ip= \Request::ip();
    $ipaddress = $_SERVER['REMOTE_ADDR'];
   print_r("ADDRESS____".$ipaddress);
    $data = \Location::get('103.197.221.170');
  //  print_r($data);
    dd($data);
});

Route::resource('frontendCropprediction/cropprediction', 'Cropperdiction\\CroppredictionController');

Route::get('cropinfo/data', 'Cropinfp\CropinfoController@index');
