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

Route::group(['namespace' => 'Api', 'as' => 'api.'], function(){
    Route::name('login')->post('login', 'AuthController@login');
    Route::name('refresh')->get('refresh', 'AuthController@refresh');

    // O logout não pode ficar no grupo interno a baixo para não ser gerado um novo token de forma automática
    Route::name('logout')->post('logout', 'AuthController@logout')->middleware(['auth:api']);

    Route::group(['middleware' => ['auth:api', 'jwt.refresh']], function (){
        Route::name('me')->get('me', 'AuthController@me');
        Route::resource('categories', 'CategoryController', ['except' => ['create', 'edit']]);
        Route::patch('products/{product}/restore', 'ProductController@restore')->name('products.restore');
        Route::resource('products', 'ProductController', ['except' => ['create', 'edit']]);
        Route::resource('products.categories', 'ProductCategoryController', ['only' => ['index', 'store', 'destroy']]);
        Route::resource('products.photos', 'ProductPhotoController', ['except' => ['create', 'edit']]);
//    Route::post('products/{product}/photos/{photo}', 'ProductPhotoController@update')->name('products.photos.update');
        Route::resource('inputs', 'ProductInputController', ['only' => ['index', 'store', 'show']]);
        Route::resource('outputs', 'ProductOutputController', ['only' => ['index', 'store', 'show']]);
        Route::resource('users', 'UserController', ['except' => ['create', 'edit']]);
    });
});
