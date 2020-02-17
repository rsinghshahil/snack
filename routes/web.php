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

// These are the user routes that needs authentication for order and ...
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/user_log', 'HomeController@userLog')->name('user-log');
Route::resource('/orders', 'Backend\DailyOrdersController');
Route::resource('/meal_link', 'LinkController');
Route::post('/rating', 'HomeController@postStar')->name('postStar');


// These are the admin Register & Login Routes ...
Route::get('/login/admin', 'Auth\LoginController@showAdminLoginForm');
Route::get('/register/admin', 'Auth\RegisterController@showAdminRegisterForm');
Route::post('/login/admin', 'Auth\LoginController@adminLogin');
Route::post('/register/admin', 'Auth\RegisterController@createAdmin');

// These are the dashboards routes
Route::group(['prefix' => 'admin', 'as' => '.admin', 'namespace' => 'backend', 'middleware' => 'auth:admin'], function () {
    Route::get('/dashboard','DashboardController@index')->name('index');
});


Route::group(['prefix' => '/snack','namespace' => 'backend','middleware'=>'auth:admin'], function () {
    Route::view('/{vue_capture?}','/backend/layouts/app')->where('vue_capture', '[\/\w\.-]*');
});

Route::group(['prefix' => '/api','namespace' => 'Backend','middleware'=>'auth:admin'], function () {
    Route::resource('/users','UserController');
    Route::get('/users/activate/{id}','UserController@activate');
    Route::get('/users/terminate/{id}','UserController@terminate');
    Route::resource('/meals','MealController');
    Route::get('/meals/activate/{id}','MealController@activate');
    Route::get('/meals/deactivate/{id}','MealController@terminate');
    Route::resource('/broadcast-meal','BroadcastMealController');

    Route::post('/broadcast-meal/makecall','BroadcastMealController@makeCall');

    Route::resource('/manage_orders','ManageOrderController');
    Route::get('/manage_orders/take/{id}','ManageOrderController@take');
    Route::get('/manage_orders/ready/{id}','ManageOrderController@ready');
    Route::get('/manage_orders/deliver/{id}','ManageOrderController@deliver');

    Route::resource('/meal_link','MealLinkController');

});
// Route::group(['prefix' => '/','namespace' => 'backend','middleware'=>'auth:admin'], function () {
//     Route::view('/{vue_capture?}','/backend/layouts/app')->where('vue_capture', '[\/\w\.-]*');
// });
