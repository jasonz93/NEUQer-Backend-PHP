<?php
/**
 * Created by PhpStorm.
 * User: nicholas
 * Date: 16-3-12
 * Time: 下午9:49
 */

return [
    'auth' => [
        'mongo' => env('NEUQER_MONGO_STR'),
        'dbname' => env('NEUQER_AUTH_DBNAME')
    ],
    'bbs' => [
        'mongo' => env('NEUQER_MONGO_STR'),
        'dbname' => env('NEUQER_BBS_DBNAME')
    ],
    'home' => [
        'mongo' => env('NEUQER_MONGO_STR'),
        'dbname' => env('NEUQER_HOME_DBNAME')
    ],
];