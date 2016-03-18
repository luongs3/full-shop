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

//Route::get('/', function () {
//    return view('welcome');
//});
//common
Route::get('select-districts/{province_id}',array('as'=> 'select-districts','uses' => 'OrderController@selectDistricts'));

Route::get('/404', array('as' => '404' , 'uses' =>  'IndexController@getErrorPage'));
//main page
Route::get('',array('as' => '/', 'uses' => 'IndexController@index')) ;
Route::group(array('prefix' => 'index'),function(){
   Route::get('',array('as' => 'index', 'uses' => 'IndexController@index')) ;
   Route::get('search/{key}',array('as' => 'index.search', 'uses' => 'IndexController@search')) ;
});

Route::group(array('prefix' => 'manage'),function(){
    Route::post('save', array('as'=>'manage.save', 'uses' => 'IndexController@save'));
    Route::get('', array('as'=>'manage','middleware' => 'role', 'uses' => 'IndexController@manage'));
    Route::post('delete-banner', array('as'=>'manage.delete-banner','middleware' => 'role', 'uses' => 'IndexController@deleteBanner'));
    Route::get('test', array('as'=>'manage.test', 'uses' => 'IndexController@test'));
});

//products
Route::group(array( 'prefix' => 'products'),function(){
    Route::get("/", array('as' => 'products','uses'=> 'ProductController@index'));
    Route::get("create", array('as' => 'products.create','middleware' => 'role','uses'=> 'ProductController@create'));
    Route::get("manage", array('as' => 'products.manage','middleware' => 'role','uses'=> 'ProductController@manage'));
    Route::get("edit/{id}", array('as' => 'products.edit','middleware' => 'role', 'uses' => 'ProductController@edit'));
    Route::post("save/{id?}", array('as' => 'products.save','middleware' => 'role','uses'=> 'ProductController@save'));
    Route::get("delete/{id}", array('as' => 'products.delete','middleware' => 'role', 'uses' => 'ProductController@delete'));
    Route::post("massive-delete", array('as' => 'products.massive-delete','middleware' => 'role', 'uses' => 'ProductController@massiveDelete'));
//    featured product
    Route::post("update-fp", array('as' => 'products.update-fp','middleware' => 'role', 'uses' => 'ProductController@setFeaturedProducts'));
    Route::get("manage-fp", array('as' => 'products.manage-fp','middleware' => 'role', 'uses' => 'ProductController@getFeaturedProducts'));
    Route::get("delete-fp/{id}", array('as' => 'products.delete-fp','middleware' => 'role', 'uses' => 'ProductController@deleteFeaturedProduct'));
    Route::post("massive-delete-fp", array('as' => 'products.massive-delete-fp','middleware' => 'role', 'uses' => 'ProductController@massiveDeleteFeaturedProducts'));
//  product category
    Route::get("category/{id}/{order_by?}/{direction?}", array('as' => 'products.category', 'uses' => 'ProductController@getCategoryProducts'));
//    test
    Route::get("test-view", array('as' => 'products.test-view','uses'=> 'ProductController@testView'));
    Route::get("test", array('as' => 'products.test','uses'=> 'ProductController@test'));
//  product detail
    Route::get("{sku}", array('as' => 'products.detail', 'uses' => 'ProductController@productDetail'));
});
//categories
Route::group(array( 'prefix' => 'categories'),function(){
    Route::get("/", array('as' => 'categories','uses'=> 'CategoryController@index'));
    Route::get("create", array('as' => 'categories.create','middleware' => 'role','uses'=> 'CategoryController@create'));
    Route::get("manage", array('as' => 'categories.manage','middleware' => 'role','uses'=> 'CategoryController@manage'));
    Route::get("edit/{id}", array('as' => 'categories.edit','middleware' => 'role', 'uses' => 'CategoryController@edit'));
    Route::post("save/{id?}", array('as' => 'categories.save','middleware' => 'role','uses'=> 'CategoryController@save'));
    Route::get("delete/{id}", array('as' => 'categories.delete','middleware' => 'role', 'uses' => 'CategoryController@delete'));
    Route::post("massive-delete", array('as' => 'categories.massive-delete','middleware' => 'role', 'uses' => 'CategoryController@massiveDelete'));
    Route::get("abc", array('as' => 'categories.abc','uses'=> 'CategoryController@abc'));
    Route::get("test-view", array('as' => 'categories.test-view','uses'=> 'CategoryController@testView'));
    Route::get("test", array('as' => 'categories.test','uses'=> 'CategoryController@test'));
});
//orders
Route::group(array( 'prefix' => 'orders'),function(){
    Route::get("/", array('as' => 'orders','uses'=> 'OrderController@index'));
    Route::get("create", array('as' => 'orders.create','middleware' => 'role','uses'=> 'OrderController@create'));
    Route::get("manage", array('as' => 'orders.manage','middleware' => 'role','uses'=> 'OrderController@manage'));
    Route::post("update-status", array('as' => 'orders.update-status','middleware' => 'role','uses'=> 'OrderController@updateStatus'));
    Route::get("edit/{id}", array('as' => 'orders.edit','middleware' => 'role', 'uses' => 'OrderController@edit'));
    Route::get("edit/{id}/address", array('as' => 'orders.edit-address','middleware' => 'role', 'uses' => 'OrderController@editAddress'));
    Route::post("save/{id?}", array('as' => 'orders.save','middleware' => 'role','uses'=> 'OrderController@save'));
    Route::get("delete/{id}", array('as' => 'orders.delete','middleware' => 'role', 'uses' => 'OrderController@delete'));
    Route::post("massive-delete", array('as' => 'orders.massive-delete','middleware' => 'role', 'uses' => 'OrderController@massiveDelete'));
    Route::get("abc", array('as' => 'orders.abc','uses'=> 'OrderController@abc'));
    Route::get("test-view", array('as' => 'orders.test-view','uses'=> 'OrderController@testView'));
    Route::get("test", array('as' => 'orders.test','uses'=> 'OrderController@test'));
});
//cart
Route::group(array( 'prefix' => 'cart'),function(){
    Route::get("", array('as' => 'cart','uses'=> 'OrderController@cart'));
    Route::post("add-item", array('as' => 'cart.add-item','uses'=> 'OrderController@addItem'));
    Route::post("remove-item", array('as' => 'cart.remove-item','uses'=> 'OrderController@removeItem'));
    Route::post("change-quantity", array('as' =>'cart.change-quantity','uses'=> 'OrderController@changeQuantity'));
});
//checkout
Route::get("checkout", array('as' => 'get-checkout','uses'=> 'OrderController@getCheckout'));
Route::post("post-checkout", array('as' => 'post-checkout','uses'=> 'OrderController@postCheckout'));
//result
Route::get("result", array('as' => 'result','uses'=> 'OrderController@result'));

//Users
Route::group(array( 'prefix' => 'users'),function(){
    Route::get("/", array('as' => 'users','uses'=> 'UserController@index'));
    Route::get("create", array('as' => 'users.create','uses'=> 'UserController@create'));
    Route::get("manage", array('as' => 'users.manage','uses'=> 'UserController@manage'));
    Route::get("edit/{id}", array('as' => 'users.edit', 'uses' => 'UserController@edit'));
    Route::post("save/{id?}", array('as' => 'users.save','uses'=> 'UserController@save'));
    Route::get("delete/{id}", array('as' => 'users.delete', 'uses' => 'UserController@delete'));
    Route::post("massive-delete", array('as' => 'users.massive-delete', 'uses' => 'UserController@massiveDelete'));
    Route::get("abc", array('as' => 'users.abc','uses'=> 'UserController@abc'));
    Route::get("test-view", array('as' => 'users.test-view','uses'=> 'UserController@testView'));
    Route::post("test", array('as' => 'users.test','uses'=> 'UserController@test'));
});
// Authentication routes...
Route::group(array( 'prefix' => 'auth'),function(){
    Route::get('login', array('as' => 'auth.login', 'uses' => 'Auth\AuthController@getLogin'));
    Route::post('login', 'Auth\AuthController@postLogin');
    Route::get('logout', array('as' => 'auth.logout', 'uses' => 'Auth\AuthController@getLogout'));

// Registration routes...
    Route::get('register', array('as' => 'auth.register', 'uses' => 'Auth\AuthController@getRegister'));
    Route::post('register', 'Auth\AuthController@postRegister');
});


Route::controllers([
    'password' => 'Auth\PasswordController',
]);

Route::get('session/destroy', array('as' => 'session.destroy', 'uses' => 'IndexController@sessionDestroy'));
Route::get('test', array('as' => 'index.test', 'uses' => 'IndexController@test'));