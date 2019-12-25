<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/**
 * Categories Endpoints
 */
Route::GET('categories', 'CategoryController@index');
Route::GET('categories/{slug}', 'CategoryController@show');
Route::POST('categories', 'CategoryController@store');
Route::PUT('categories/{slug}', 'CategoryController@update');
Route::Delete('categories/{slug}','CategoryController@destroy');

/**
 *  Courses Endpoints
 */
Route::GET('courses', 'CourseController@index');
Route::GET('courses/{slug}', 'CourseController@show');
Route::POST('courses', 'CourseController@store');
Route::PUT('courses/{slug}', 'CourseController@update');
Route::Delete('courses/{slug}','CourseController@destroy');

/**
 * Images Endpoint
 */
Route::POST('upload', 'ImageController@store');


