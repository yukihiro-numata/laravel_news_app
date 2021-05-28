<?php

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

Route::group(['middleware' => ['api']], function() {
    Route::get('articles', 'Api\ArticlesController@list');
    Route::post('articles', 'Api\ArticlesController@create');
    Route::get('articles/{article_id}', 'Api\ArticlesController@get');
    Route::put('articles/{article_id}', 'Api\ArticlesController@update');
    Route::delete('articles/{article_id}', 'Api\ArticlesController@delete');
});
