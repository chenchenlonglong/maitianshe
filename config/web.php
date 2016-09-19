<?php

$params = require(__DIR__ . '/params.php');


Yii::$classMap['Functions'] = '@app/libs/Functions.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'defaultRoute' => 'index', //默认控制器
//    'timeZone'=>'Asia/Chongqing',//时区
    'modules' => [
        'admin' => ['class' => 'app\modules\admin\Admin'],
        'invite' => ['class' => 'app\modules\invite\Invite'],
        'goods' => ['class' => 'app\modules\goods\Goods'],
        'user' => ['class' => 'app\modules\user\User'],
        'task' => ['class' => 'app\modules\task\Task'],
        'audit' => ['class' => 'app\modules\audit\Audit'],

    ],
    'components' => [

        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            'itemTable' => 'auth_item',
            'assignmentTable' => 'auth_assignment',
            'itemChildTable' => 'auth_item_child',
        ],

        'request' => [
            'cookieValidationKey' => 'chenlong_',
        ],
    //    'redis' => [
    //        'class' => 'yii\redis\Connection',
     //       'hostname' => '',
    //        'port' => 6379,
   //         'database' => 0,
   //     ],
        'cache' => [
            'class' => 'yii\redis\Cache',
            'keyPrefix' => 'yii_admin_cache_',
            'redis' => [                
                'hostname' => '10.10.31.134',
                'port' => 6379,
                'database' => 0
            ]
        ],
//        'session' => [
//            'class' => 'yii\redis\Session',
//            'keyPrefix' => 'yii_admin_session_',
//            'redis' => [
//                'hostname' => '120.132.70.111',
//                'port' =>6400,
//                'database' => 0,
//            ],
//        ],
        'member' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => require(__DIR__ . '/db.php'),
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
