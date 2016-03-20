<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {
    Route::group(['namespace' => 'Auth'], function () {
        Route::get('/auth/login', 'AuthController@getLogin');
        Route::post('/auth/login', 'AuthController@postLogin');
        Route::get('/auth/logout', 'AuthController@getLogout');
        Route::get('/auth/register', 'AuthController@getRegister');
        Route::post('/auth/register', 'AuthController@postRegister');
    });

    Route::group(['namespace' => 'Wx3rd'], function () {
        Route::get('/wx3rd', function () {
            return view('wx3rd.index');
        });
        Route::get('/wx3rd/authorize', [
            'uses' => 'Wx3rdController@showAuthorize',
            'as' => 'wx3rd.authorize',
            'middleware' => ['auth']
        ]);
        Route::get('/wx3rd/authorize/callback', [
            'uses' => 'Wx3rdController@showAuthorizeCallback',
            'as' => 'wx3rd.authorize.callback',
            'middleware' => ['auth']
        ]);
        Route::get('/wx3rd/mp/{mp}/oauth', [
            'uses' => 'MPController@getOAuth',
            'as' => 'wx3rd.mp.oauth'
        ]);
        Route::get('/wx3rd/mp/{mp}', function (\NEUQer\Wx3rdMP $mp) {
            return Response::json($mp);
        });

        Route::group(['middleware' => [
            'weixin.oauth',
            'auth'
        ]], function () {
            Route::get('/wx3rd/prod/mp/{mp}/cet', [
                'uses' => 'CETController@getList'
            ]);
            Route::get('/wx3rd/mp/{mp}/cet/list', [
                'uses' => 'CETController@getList',
                'as' => 'cet.list'
            ]);
            Route::get('/wx3rd/mp/{mp}/cet/add', [
                'uses' => 'CETController@getAdd',
                'as' => 'cet.add'
            ]);
            Route::post('/wx3rd/mp/{mp}/cet/add', [
                'uses' => 'CETController@postAdd',
                'as' => 'cet.add.action'
            ]);
            Route::get('/wx3rd/mp/{mp}/cet/{admission}/edit', [
                'uses' => 'CETController@getEdit',
                'as' => 'cet.edit'
            ]);
            Route::post('/wx3rd/mp/{mp}/cet/{admission}/edit', [
                'uses' => 'CETController@postEdit',
                'as' => 'cet.edit.action'
            ]);
            Route::get('/wx3rd/mp/{mp}/cet/{admission}/delete', [
                'uses' => 'CETController@getDelete',
                'as' => 'cet.delete'
            ]);
        });
    });


});

Route::group(['middleware' => ['api']], function () {
    Route::group(['namespace' => 'Wx3rd'], function () {
        Route::get('/wx3rd/mp/{mp}/refresh', [
            'uses' => 'MPController@getRefresh',
            'as' => 'wx3rd.mp.refresh'
        ]);
    });

    Route::get('/wx3rd/test', function () {
        return Response::make(WeixinPlatform::generateAuthorizationUrl());
    });

    Route::group(['namespace' => 'REST'], function () {
        Route::post('/api/auth', [
            'uses' => 'AuthController@postAuth',
            'as' => 'api.auth.login'
        ]);
        Route::get('/api/auth/user', [
            'middleware' => 'api.auth',
            'uses' => 'AuthController@getUser'
        ]);
        Route::get('/api/home', [
            'uses' => 'HomeController@getHome',
            'as' => 'api.home'
        ]);
        Route::get('/api/home/history', [
            'uses' => 'HomeController@getHistory',
            'as' => 'api.home.history'
        ]);

        Route::get('/api/bbs/tag', [
            'uses' => 'BBSController@getTags',
            'as' => 'api.bbs.tag'
        ]);
        Route::get('/api/bbs/topic', [
            'uses' => 'BBSController@getTopics',
            'as' => 'api.bbs.topic'
        ]);
        Route::get('/api/bbs/topic/{topic}', [
            'uses' => 'BBSController@getTopic',
            'as' => 'api.bbs.topic.detail',
            'middleware' => ['api.auth']
        ]);
    });
});

Route::group(['namespace' => 'Wx3rd'], function () {
    Route::post('/wx3rd/authorize', [
        'uses' => 'Wx3rdController@handleAuthorizationPush'
    ]);
    Route::post('/wx3rd/mp/{mp}/event', [
        'uses' => 'MPController@postEvent'
    ]);
});
