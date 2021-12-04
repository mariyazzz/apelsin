<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
  'id'         => 'apelsin',
  'name'       => 'Apelsin',
  'basePath'   => dirname(__DIR__),
  'language'   => 'ru',
  'timeZone'   => 'Europe/Moscow',
  'bootstrap'  => ['log'],
  'aliases'    => [
    '@bower' => '@vendor/bower-asset',
    '@npm'   => '@vendor/npm-asset',
  ],
  'modules'    => [
    'user'           => [
      'class' => 'app\modules\user\Module',
      //'shouldBeActivated' => true
    ],
    'administration' => [
      'class' => 'app\modules\administration\Module',
    ],
  ],
  'controllerMap' => [
  ],
  'components' => [
    'user'        => [
      'class'           => 'yii\web\User',
      'identityClass'   => 'app\models\User',
      'loginUrl'        => ['/user/sign-in/login'],
      'enableAutoLogin' => true,
    ],
    'authManager' => [
      'class' => 'yii\rbac\DbManager',
    ],
    'request'     => [
      'cookieValidationKey' => '78o3G4xGEF4jxyvEKJGcirSKFQcv9xW',
    ],
    'cache'       => [
      'class' => 'yii\caching\FileCache',
    ],
    'log'         => [
      'traceLevel' => YII_DEBUG ? 3 : 0,
      'targets'    => [
        [
          'class'  => 'yii\log\FileTarget',
          'levels' => ['error', 'warning'],
        ],
      ],
    ],
    'db'          => require(__DIR__ . '/db.php'),
    'urlManager'  => [
      'enablePrettyUrl' => true,
      'showScriptName'  => false,
      'hostInfo'        => 'http://apelsin.pony-service.com',
      'rules'           => [
      ],
    ],
    'i18n'        => [
      'translations' => [
        '*' => [
          'class'          => 'yii\i18n\PhpMessageSource',
          'basePath'       => '@app/messages', // if advanced application, set @frontend/messages
          'sourceLanguage' => 'ru',
        ],
      ],
    ],
  ],
  'params'     => require(__DIR__ . '/params.php'),
];

if (true || YII_ENV_DEV) {
  // configuration adjustments for 'dev' environment
  $config['bootstrap'][] = 'debug';
  $config['modules']['debug'] = [
    'class'      => 'yii\debug\Module',
    'allowedIPs' => ['94.25.228.16'],
  ];

  $config['bootstrap'][] = 'gii';
  $config['modules']['gii'] = [
    'class'      => 'yii\gii\Module',
    'allowedIPs' => ['*'],
  ];
}

return $config;
