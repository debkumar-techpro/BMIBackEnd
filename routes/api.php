<?php

$api = app('Dingo\Api\Routing\Router');

// default v1 version API

// header  Accept:application/vnd.lumen.v1+json
$api->version('v1', [
    'namespace' => 'App\Http\Controllers\Api\V1',
    'middleware' => []
], function ($api) {
    // test
    $api->get('test', 'TestController@test');

    $api->group([
        'prefix' => 'auth',
    ], function ($api) {
        // register
        $api->post('register', [
            'as' => 'authorize.register',
            'uses' => 'AuthController@register',
        ]);
        $api->post('register_test', [
            'as' => 'authorize.register_test',
            'uses' => 'AuthController@register_test',
        ]);

        // login
        $api->post('login', [
            'as' => 'authorize.login',
            'uses' => 'AuthController@login',
        ]);

        // refresh
        $api->post('refresh', [
            'as' => 'authorize.refresh',
            'uses' => 'AuthController@refresh',
        ]);

        // me
        $api->get('me', [
            'as' => 'authorize.me',
            'uses' => 'AuthController@me',
        ]);

        // getCurrentToken
        $api->post('token', [
            'as' => 'authorize.getCurrentToken',
            'uses' => 'AuthController@getCurrentToken',
        ]);

        // logout
        $api->post('logout', [
            'as' => 'authorize.logout',
            'uses' => 'AuthController@logout',
        ]);
    });

    // need authentication
    $api->group([
        //'middleware' => 'api.auth'
    ], function ($api) {
        // User
        // my detail
        // $api->get('user', [
        //     'as' => 'user.show',
        //     'uses' => 'UserController@show'
        // ]);
        $api->get('user', [
            'as' => 'user.index',
            'uses' => 'UserController@index'
        ]);
        // update info
        $api->patch('user', [
            'as' => 'users.update',
            'uses' => 'UserController@patch'
        ]);
        // edit password
        $api->put('user/password', [
            'as' => 'user.edit.password',
            'uses' => 'UserController@editPassword'
        ]);

        // RESTful
        $api->resource('/post', 'PostController');
        $api->resource('/programme', 'ProgrammeController');

        //store_file
        $api->post('programme/files', [
            'as' => 'programme.store_file',
            'uses' => 'ProgrammeController@store_file'
        ]);
    });

});

// v2  version API
// header  Accept:application/vnd.lumen.v2+json
$api->version('v2', [
    'namespace' => 'App\Http\Controllers\Api\V2'
], function ($api) {

    // test
    $api->get('test', 'TestController@test');

});