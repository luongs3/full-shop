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
//main page
Route::get('/', array('as' => '/' , 'uses' =>  'IndexController@index'));
Route::get('/404', array('as' => '404' , 'uses' =>  'IndexController@getErrorPage'));

//products
Route::group(array( 'prefix' => 'products'),function(){
    Route::get("/", array('as' => 'products','uses'=> 'ProductController@index'));
    Route::get("create", array('as' => 'products.create','middleware' => 'auth','uses'=> 'ProductController@create'));
    Route::get("manage", array('as' => 'products.manage','middleware' => 'auth','uses'=> 'ProductController@manage'));
    Route::get("edit/{id}", array('as' => 'products.edit','middleware' => 'auth', 'uses' => 'ProductController@edit'));
    Route::post("save/{id?}", array('as' => 'products.save','middleware' => 'auth','uses'=> 'ProductController@save'));
    Route::get("delete/{id}", array('as' => 'products.delete','middleware' => 'auth', 'uses' => 'ProductController@delete'));
    Route::post("massive-delete", array('as' => 'products.massive-delete','middleware' => 'auth', 'uses' => 'ProductController@massiveDelete'));
//    featured product
    Route::post("update-fp", array('as' => 'products.update-fp','middleware' => 'auth', 'uses' => 'ProductController@setFeaturedProducts'));
    Route::get("manage-fp", array('as' => 'products.manage-fp','middleware' => 'auth', 'uses' => 'ProductController@getFeaturedProducts'));
    Route::get("delete-fp/{id}", array('as' => 'products.delete-fp','middleware' => 'auth', 'uses' => 'ProductController@deleteFeaturedProduct'));
    Route::post("massive-delete-fp", array('as' => 'products.massive-delete-fp','middleware' => 'auth', 'uses' => 'ProductController@massiveDeleteFeaturedProducts'));
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
    Route::get("create", array('as' => 'categories.create','middleware' => 'auth','uses'=> 'CategoryController@create'));
    Route::get("manage", array('as' => 'categories.manage','middleware' => 'auth','uses'=> 'CategoryController@manage'));
    Route::get("edit/{id}", array('as' => 'categories.edit','middleware' => 'auth', 'uses' => 'CategoryController@edit'));
    Route::post("save/{id?}", array('as' => 'categories.save','middleware' => 'auth','uses'=> 'CategoryController@save'));
    Route::get("delete/{id}", array('as' => 'categories.delete','middleware' => 'auth', 'uses' => 'CategoryController@delete'));
    Route::post("massive-delete", array('as' => 'categories.massive-delete','middleware' => 'auth', 'uses' => 'CategoryController@massiveDelete'));
    Route::get("abc", array('as' => 'categories.abc','uses'=> 'CategoryController@abc'));
    Route::get("test-view", array('as' => 'categories.test-view','uses'=> 'CategoryController@testView'));
    Route::get("test", array('as' => 'categories.test','uses'=> 'CategoryController@test'));
});
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

Route::get('test', array('as' => 'index.test', 'uses' => 'IndexController@test'));