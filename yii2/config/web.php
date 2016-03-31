<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'components' => [
        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => [
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'tweet',
                ],
               'GET tweet/hashtag-statistic/<from>/<to>' => 'tweet/hashtag-statistic',
               'GET tweet/last-tweets/<count>' => 'tweet/last-tweets',
               'GET tweet/find-by-hashtag/<hashtag>' => 'tweet/find-by-hashtag',
            ],

        ],
        'tweetlastfinder' => [
            'class' => 'app\components\TweetLastFinder',
        ],
        'tweethashtagfinder' => [
            'class' => 'app\components\TweetHashtagFinder',
        ],
        'tweetstatistic' => [
            'class' => 'app\components\TweetStatistic',
        ],
        'request' => [
//             !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'dp3BtGMUeg6sgPW9DAXIapoK9b502rnr',
        'parsers' =>['application/json' => 'yii\web\JsonParser', ],
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],

        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a tdransport
            // for the mailer to send real emails.
            'useFileTransport' => true,
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
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'allowedIPs' => ['127.0.0.1', '::1','192.168.100.*']
    ];
}

return $config;
