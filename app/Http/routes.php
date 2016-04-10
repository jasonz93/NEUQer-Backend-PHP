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
    Route::get('/views/{name}', function ($name) {
        error_log($name);
        return view($name);
    })->where('name', '.*');
    Route::group(['prefix' => 'api'], function () {
        Route::group([
            'namespace' => 'Wx3rd',
            'prefix' => 'wx3rd',
            'middleware' => ['auth']
        ], function () {
            Route::get('/mps', [
                'uses' => 'Wx3rdController@getMPs'
            ]);
            Route::group([
                'namespace' => 'Manage',
                'middleware' => ['own.mp']
            ], function () {
                Route::get('/mp/{mp}/info', [
                    'uses' => 'IndexController@getInfo',
                    'as' => 'wx3rd.mp.manage.info'
                ]);
                Route::get('/mp/{mp}/refresh', [
                    'uses' => 'IndexController@getRefresh',
                    'as' => 'wx3rd.mp.manage.refresh'
                ]);
                Route::get('/mp/{mp}/manage/reply', [
                    'uses' => 'ReplyController@getIndex',
                    'as' => 'wx3rd.mp.manage.reply'
                ]);
                Route::get('/mp/{mp}/reply/handlers', [
                    'uses' => 'ReplyController@getHandlers',
                    'as' => 'wx3rd.mp.manage.reply.handlers'
                ]);
                Route::post('/mp/{mp}/reply/handler', [
                    'uses' => 'ReplyController@createHandler',
                    'as' => 'wx3rd.mp.manage.reply.handler.create'
                ]);
                Route::put('/mp/{mp}/reply/handler/{eventHandler}', [
                    'uses' => 'ReplyController@updateHandler',
                    'as' => 'wx3rd.mp.manage.reply.handler.update'
                ]);
                Route::delete('/mp/{mp}/reply/handler/{eventHandler}', [
                    'uses' => 'ReplyController@deleteHandler',
                    'as' => 'wx3rd.mp.manage.reply.handler.delete'
                ]);
                Route::get('/mp/{mp}/menu/current', [
                    'uses' => 'MenuController@getCurrent',
                    'as' => 'wx3rd.mp.manage.menu.current'
                ]);
                Route::post('/mp/{mp}/menu', [
                    'uses' => 'MenuController@postMenu',
                    'as' => 'wx3rd.mp.manage.menu.create'
                ]);
                Route::get('/mp/{mp}/shake/audit', [
                    'uses' => 'ShakeController@getAudit',
                    'as' => 'wx3rd.mp.manage.shake.audit.status'
                ]);
            });
        });
    });

    Route::group([
        'prefix' => 'wx3rd',
        'namespace' => 'Wx3rd'
    ], function () {
        Route::group(['middleware' => ['auth']], function () {
            Route::any('/manage/{path?}', function () {
                return view('wx3rd.layouts.master');
            })->where('path', '.+');
            Route::get('/authorize', [
                'uses' => 'Wx3rdController@showAuthorize',
                'as' => 'wx3rd.authorize'
            ]);
            Route::get('/authorize/callback', [
                'uses' => 'Wx3rdController@showAuthorizeCallback',
                'as' => 'wx3rd.authorize.callback'
            ]);
        });
        Route::get('/mp/{mp}/oauth', [
            'uses' => 'MPController@getOAuth',
            'as' => 'wx3rd.mp.oauth'
        ]);
        Route::get('/mp/{mp}', function (\NEUQer\Wx3rdMP $mp) {
            return Response::json($mp);
        });

        Route::group(['middleware' => [
            'weixin.oauth',
            'auth'
        ]], function () {
            Route::get('/prod/mp/{mp}/cet', [
                'uses' => 'CETController@getList'
            ]);
            Route::get('/mp/{mp}/cet/list', [
                'uses' => 'CETController@getList',
                'as' => 'cet.list'
            ]);
            Route::get('/mp/{mp}/cet/add', [
                'uses' => 'CETController@getAdd',
                'as' => 'cet.add'
            ]);
            Route::post('/mp/{mp}/cet/add', [
                'uses' => 'CETController@postAdd',
                'as' => 'cet.add.action'
            ]);
            Route::get('/mp/{mp}/cet/{admission}/edit', [
                'uses' => 'CETController@getEdit',
                'as' => 'cet.edit'
            ]);
            Route::post('/mp/{mp}/cet/{admission}/edit', [
                'uses' => 'CETController@postEdit',
                'as' => 'cet.edit.action'
            ]);
            Route::get('/mp/{mp}/cet/{admission}/delete', [
                'uses' => 'CETController@getDelete',
                'as' => 'cet.delete'
            ]);




            //the signin stsyem

            Route::get('/mp/{mp}/qrcode', [
               'uses' => 'SignInController@index'
            ]);

            Route::post('/mp/{mp}/qrcode/add',[
                'uses' => 'SignInController@postAdd'
            ]);
            Route::get('/mp/{mp}/qrcode/info',[
                'uses' => 'SignInController@getInfo',
                'as'   => 'signin.info'
            ]);
            Route::get('/mp/{mp}/qrcode/list',[
                'uses' => 'SignInController@getList',
                'as'   => 'signin.list'
            ]);
            Route::get('/mp/{mp}/qrcode/getcode',[
                'uses' => 'SignInController@getQrcode',
            ]);
            Route::get('/mp/{mp}/qrcode/delete',[
                'uses' => 'SignInController@getDelete'
            ]);
        });
    });

    Route::group([
        'namespace' => 'Admin',
        'middleware' => ['role:admin']
    ], function () {
        Route::get('/admin', [
            'uses' => 'IndexController@getIndex',
            'as' => 'admin'
        ]);
        Route::group(['namespace' => 'Wx3rd'], function () {
            Route::get('/admin/wx3rd/mp', [
                'uses' => 'MPController@getList',
                'as' => 'admin.wx3rd.mp.list'
            ]);
            Route::get('/admin/wx3rd/mp/{mp}/info', [
                'uses' => 'MPController@getInfo',
                'as' => 'admin.wx3rd.mp.info'
            ]);
            Route::get('/admin/wx3rd/mp/{mp}/refresh', [
                'uses' => 'MPController@getRefresh',
                'as' => 'admin.wx3rd.mp.refresh'
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
        Route::get('/api/bbs/topic/by-id', [
            'uses' => 'BBSController@getTopic',
            'as' => 'api.bbs.topic.detail',
            'middleware' => ['api.auth']
        ]);
        Route::get('/api/bbs/topic/by-tag', [
            'uses' => 'BBSController@getTopicsByTag',
            'as' => 'api.bbs.topic.bytag'
        ]);
        Route::get('/api/bbs/reply/by-topic', [
            'uses' => 'BBSController@getReplies',
            'as' => 'api.bbs.reply',
            'middleware' => ['api.auth']
        ]);
        Route::get('/api/bbs/reply/by-id', [
            'uses' => 'BBSController@getReply',
            'as' => 'api.bbs.reply.detail',
            'middleware' => ['api.auth']
        ]);
        Route::get('/api/bbs/comment/by-reply', [
            'uses' => 'BBSController@getComments',
            'as' => 'api.bbs.comment'
        ]);
        Route::put('/api/bbs/topic/like', [
            'uses' => 'BBSController@likeTopic',
            'as' => 'api.bbs.topic.like',
            'middleware' => ['api.auth']
        ]);
        Route::put('/api/bbs/reply/like', [
            'uses' => 'BBSController@likeReply',
            'as' => 'api.bbs.reply.like',
            'middleware' => ['api.auth']
        ]);
        Route::get('/api/bbs/topic/stick/by-tag', function () {
            return Response::json([]);
        });
        Route::put('/api/bbs/topic', [
            'uses' => 'BBSController@postTopic',
            'as' => 'api.bbs.topic.post',
            'middleware' => ['api.auth']
        ]);
        Route::put('/api/bbs/reply', [
            'uses' => 'BBSController@postReply',
            'as' => 'api.bbs.reply.post',
            'middleware' => ['api.auth']
        ]);

        Route::get('/api/im/neuqer', [
            'uses' => 'IMController@getNeuqer',
            'as' => 'api.im.neuqer'
        ]);
        Route::get('/api/im/friend', [
            'uses' => 'IMController@getFriends',
            'as' => 'api.im.friends',
            'middleware' => ['api.auth']
        ]);
    });

    Route::group([
        'namespace' => 'Signin',
        'prefix' => 'signin'
    ], function(){
        Route::get('/qrcode/check',[
            'uses' => 'SignInController@check'
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