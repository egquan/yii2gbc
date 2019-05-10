<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'language'=>'zh-CN',
    //虚拟目录
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
        '@admin' => '@app/modules/admin',
    ],
    //模块设计
    'modules' => [
        //Admin模块
        'admin' => [
            'class' => 'admin\Module',
        ],
    ],
    //主体
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'zO1KZjLEptjxmrlqBotleP8mQK9RQMcg',
        ],
        'session' => [
            //'class' => 'yii\redis\Session'
        ],
        //缓存
        'cache' => [
            'class' => 'yii\caching\FileCache',
            //'class' => 'yii\redis\Cache',
        ],
        //前台登陆
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
            'loginUrl' =>['/site/login'],
            'identityCookie' => ['name' => '_user_identity', 'httpOnly' => true],
            'idParam' => '_user'
        ],
        //后台登陆
        'admin' =>[
            'class'=>'yii\web\User',
            'identityClass' => 'admin\models\AdminUser',
            'enableAutoLogin' => true,
            'loginUrl' =>['/admin/public/login'],
            'identityCookie' => ['name' => '_admin_identity', 'httpOnly' => true],
            'idParam' => '_admin',
            //触发登陆事件
            'on beforeLogin' => function($event) {
                $user = $event->identity; //这里的就是User Model的实例
                $user->login_time = time();
                $user->login_ip = ip2long(Yii::$app->request->userIP);
                $user->save(false);
            },
        ],
        'authManager'=>[
            'class' => 'yii\rbac\DbManager',
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.163.com',  //每种邮箱的host配置不一样
                'username' => 'egquan@163.com',
                'password' => 'xiaochun0543',
                'port' => '25',
                'encryption' => 'tls',

            ],
            'messageConfig' => [
                'charset' => 'UTF-8',
                'from' => ['egquan@163.com' => 'Gbc 音乐管理系统']
            ],
        ],
        //日志文件
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        //加载数据库
        'db' => $db,
        //路由
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        //redis缓存
        'redis' => [
            'class' => 'yii\redis\Connection',
            'hostname' => '127.0.0.1',
            'port' => 6379,
            'database' => 0,
        ],
    ],
    'as access' => [
        'class' => 'admin\components\AccessControl',
        'allowActions' => [
            '*'
        ]
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
