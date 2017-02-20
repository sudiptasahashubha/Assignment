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
   
      return redirect('/home');
});

Auth::routes();

//Route::get('/home', 'HomeController@index');

//Route::group(['middleware' => ['auth']], function()
//{
	
	Route::get('/home',['as' => 'home', 'uses' => 'PostController@index']);
	Route::get('/register','RegistrationController@create');
	Route::post('/register','RegistrationController@store');
	Route::get('/login','LoginController@create');
	Route::post('/login','LoginController@store');
	Route::get('/logout','LoginController@destroy');
	Route::get('searchbypostinput','PostController@searchbypostin');
	Route::get('searchbyuserinput','PostController@searchbyuserin');
	Route::get('searchbypostcontentinput','PostController@searchbypostcontentin');
	Route::get('new-post','PostController@create');
	Route::post('new-post','PostController@store');
	Route::get('edit/{slug}','PostController@edit');
	Route::get('commentedit/{slug}','CommentController@edit');
	Route::post('update','PostController@update');
	Route::post('commentupdate','CommentController@update');
	Route::get('delete/{id}','PostController@destroy');
	Route::get('commentdelete/{id}','CommentController@destroy');
	Route::get('/{slug}','PostController@show');
	Route::post('{postno}/comment/add','CommentController@store');
 	Route::post('searchforpost','PostController@searchforpostresult');
 	Route::post('searchforuser','PostController@searchforuserresult');
 	Route::post('searchforpostcontent','PostController@searchforpostcontentresult');
	
//});
