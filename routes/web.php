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

Route::get('/', 'UserController@show');

/*
 * Users table
 */
Route::get('/listusers','UserController@list');
Route::post('/adduser','UserController@add');
Route::put('/updateusername','UserController@change');
Route::delete('/deleteuser','UserController@delete');

/*
 * Lists table
 */
Route::get('showlists/{username}','ListController@show');
Route::post('/addlist','ListController@add');
Route::put('/updatelistname','ListController@change');
Route::delete('/deletelist','ListController@delete');

/*
 * Tasks table
 */
Route::get('/showtasks/{username}/{listname}','TaskController@list');
Route::post('/addtask','TaskController@add');
Route::put('/updatetask','TaskController@change');
Route::delete('/deletetask','TaskController@delete');