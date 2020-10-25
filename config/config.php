<?php

use app\engine\{Db, Request, Session, Router, Google};
use app\model\repositories\UserRepository;

define("DS", DIRECTORY_SEPARATOR);
define("ROOT_DIR", dirname(__DIR__));
define("CONTROLLER_NAMESPACE", "app\\controllers\\");
define("TEMPLATE_DIR", dirname(__DIR__) . "/views/");


return [
    'root_dir' =>  dirname(__DIR__),
    'templates_dir' => TEMPLATE_DIR,
    'controllers_namespaces' => 'app\controllers\\',
    'components' => [
        'db' => [
            'class' => Db::class,
            'driver' => 'mysql',
            'host' => '192.168.10.10',
            'login' => 'homestead',
            'password' => 'secret',
            'database' => 'test_db',
            'charset' => 'utf8'
        ],
        'google' => [
            'class' => Google::class
        ],
        'request' => [
            'class' => Request::class
        ],
        'router' => [
            'class' => Router::class
        ],
        'session' => [
            'class' => Session::class
        ],
        'repositories' => [
            'usersRepository' => [
                'class' => UserRepository::class
            ]
        ]
    ]
];