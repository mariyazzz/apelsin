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
    'mailer' => [
      'class' => 'yii\swiftmailer\Mailer',
      'viewPath' => '@backend/mail',
      'useFileTransport' => false,//set this property to false to send mails to real email addresses
      //comment the following array to send mail using php's mail function
      'transport' => [
        'class' => 'Swift_SmtpTransport',
        'host' => 'smtp.gmail.com',
        'username' => 'username@gmail.com',
        'password' => 'password',
        'port' => '587',
        'encryption' => 'tls',
      ],
    ],
    'db'          => require(__DIR__ . '/db.php'),
    'urlManager'  => [
      'enablePrettyUrl' => false,
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
    'allowedIPs' => ['*'],
  ];

  $config['bootstrap'][] = 'gii';
  $config['modules']['gii'] = [
    'class'      => 'yii\gii\Module',
    'allowedIPs' => ['*'],
  ];
}

return $config;
