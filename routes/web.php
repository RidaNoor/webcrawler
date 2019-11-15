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



//Route::get('/Crawl','HomeController@index');

 Route::get('/', 'HomeController@Index');
 Route::get('/status/{url}', 'HomeController@Results')->name('status');

 Route::post('/results/{url}', 'HomeController@Status');
 Route::post('/home', 'HomeController@RequestStatus');


