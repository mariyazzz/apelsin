<?php

$config = [
  'id'                  => 'basic-console',
  'basePath'            => dirname(__DIR__),
  'bootstrap'           => ['log'],
  'controllerNamespace' => 'app\commands',
  'components'          => [
    'cache'       => [
      'class' => 'yii\caching\FileCache',
    ],
    'log'         => [
      'targets' => [
        [
          'class'  => 'yii\log\FileTarget',
          'levels' => ['error', 'warning'],
        ],
      ],
    ],
    'db'          => require(__DIR__ . '/db.php'),
    'authManager' => [
      'class' => 'yii\rbac\DbManager',
    ],
  ],
  'params'              => require(__DIR__ . '/params.php'),

  'controllerMap' => [
    /*'fixture' => [ // Fixture generation command line.
        'class' => 'yii\faker\FixtureController',
    ],*/
    'stubs' => [
      'class' => 'bazilio\stubsgenerator\StubsController',
    ],
  ],

];

if (YII_ENV_DEV) {
  // configuration adjustments for 'dev' environment
  $config['bootstrap'][] = 'gii';
  $config['modules']['gii'] = [
    'class' => 'yii\gii\Module',
  ];
}

return $config;
