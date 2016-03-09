<?php

Yii::setAlias('@tests', dirname(__DIR__) . '/tests');

$params = require(__DIR__ . '/params.php');
$db = require(__DIR__ . '/db.php');

return [
    'id' => 'basic-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log', 'gii'],
    'controllerNamespace' => 'app\commands',
    'modules' => [
        'gii' => 'yii\gii\Module',
    ],
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'tweetloader' => [
            'class' => 'app\components\TweetLoader',
            'tweetConfig' => require(__DIR__.'/tweetConfig.php'),
        ],
        'tweetimporter' => [
            'class' => 'app\components\TweetImporter',
        ],
        'tweetshow' => [
            'class' => 'app\components\TweetShow',
        ],
        'tweethashtagfinder' => [
            'class' => 'app\components\TweetHashtagFinder',
        ],
        'tweetlastfinder' => [
            'class' => 'app\components\TweetLastFinder',
        ],
        'tweetstatistic' => [
            'class' => 'app\components\TweetStatistic',
        ],
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
    ],
    'params' => $params,
];
