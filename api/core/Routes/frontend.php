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

Media::store();

Route::get('/', function () {
    return view('yey');
});

Route::group(['namespace' => 'Core\Http\Controllers\Frontend'], function() {

    Route::get(Theme::getAssetsPath()[0] . '/{assets}', 'AssetsController@serveAssets')->where('assets', '.*');

});


