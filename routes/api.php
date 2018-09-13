<?php

$api = app('Dingo\Api\Routing\Router');

// default v1 version API

// header  Accept:application/vnd.lumen.v1+json
$api->version('v1', [
    'namespace'  => 'App\Http\Controllers\Api\V1',
    'middleware' => [],
], function ($api) {
    // test
    $api->get('test', 'TestController@test');

    $api->group([
        'prefix' => 'auth',
    ], function ($api) {
        // register
        $api->post('register', [
            'as'   => 'authorize.register',
            'uses' => 'AuthController@register',
        ]);
        $api->post('register_test', [
            'as'   => 'authorize.register_test',
            'uses' => 'AuthController@register_test',
        ]);

        // login
        $api->post('login', [
            'as'   => 'authorize.login',
            'uses' => 'AuthController@login',
        ]);

        // refresh
        $api->post('refresh', [
            'as'   => 'authorize.refresh',
            'uses' => 'AuthController@refresh',
        ]);

        // me
        $api->get('me', [
            'as'   => 'authorize.me',
            'uses' => 'AuthController@me',
        ]);

        // getCurrentToken
        $api->post('token', [
            'as'   => 'authorize.getCurrentToken',
            'uses' => 'AuthController@getCurrentToken',
        ]);

        // logout
        $api->post('logout', [
            'as'   => 'authorize.logout',
            'uses' => 'AuthController@logout',
        ]);
    });

    // need authentication
    $api->group([
        // 'middleware' => 'api.auth',
    ], function ($api) {
        // RESTful API
        $api->resource('/post', 'PostController', [
            'only' => [
            ],
        ]);
        $api->resource('/programme', 'ProgrammeController', [
            'except' => [
                'update',
                'destroy',
            ],
        ]);
        $api->resource('/programme-participant', 'ProgrammeParticipantController', [
            'only' => [
                'store',
                'show',
            ],
        ]);
        $api->resource('/programme-classformat', 'ProgrammeClassFormatController', [
            'only' => [
                'store',
                'show',
            ],
        ]);
        $api->resource('/student', 'StudentController', [
            'only' => [
            ],
        ]);
        $api->resource('/teacher', 'TeacherController', [
            'only' => [
            ],
        ]);
        $api->resource('/module', 'ModuleController', [
            'only' => [
                'show',
                'update'
            ],
        ]);

        // Custom RESTful API
        // My Details
        $api->get('user', [
            'as'   => 'user.index',
            'uses' => 'UserController@index',
        ]);
        // $api->get('user', [
        //     'as' => 'user.show',
        //     'uses' => 'UserController@show'
        // ]);
        // Show class under a programme
        $api->get('programme/classes/{programme_id}', [
            'as'   => 'programme.show-class',
            'uses' => 'ProgrammeController@show_class',
        ]);
        // Show module under a programme
        $api->get('programme/modules/{programme_id}/{class_id}', [
            'as'   => 'programme.show-module',
            'uses' => 'ProgrammeController@show_module',
        ]);
        // Show student under a programme
        $api->get('student/classes/{class_id}', [
            'as'   => 'student.show-student',
            'uses' => 'StudentController@show_by_class',
        ]);
        // Show teacher under a programme
        $api->get('teacher/classes/{class_id}', [
            'as'   => 'teacher.show-teacher',
            'uses' => 'TeacherController@show_by_class',
        ]);
        // Store file under a programme create
        $api->post('programme/files', [
            'as'   => 'programme.store-file',
            'uses' => 'ProgrammeController@store_file',
        ]);
        // Store class under a programme
        $api->post('programme/classes', [
            'as'   => 'programme.store-class',
            'uses' => 'ProgrammeController@store_class',
        ]);
        // edit password
        $api->put('user/password', [
            'as'   => 'user.edit.password',
            'uses' => 'UserController@editPassword',
        ]);
        // update info
        $api->patch('user', [
            'as'   => 'users.update',
            'uses' => 'UserController@patch',
        ]);
        // Delete file under a programme create
        $api->delete('programme/files/{files}', [
            'as'   => 'programme.destroy-file',
            'uses' => 'ProgrammeController@destroy_file',
        ]);
    });

});

// v2  version API
// header  Accept:application/vnd.lumen.v2+json
$api->version('v2', [
    'namespace' => 'App\Http\Controllers\Api\V2',
], function ($api) {
    // test
    $api->get('test', 'TestController@test');

});
