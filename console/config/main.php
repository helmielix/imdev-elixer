<?php
$params = array_merge(
    // require(__DIR__ . '/../../common/config/params.php'),
    // require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'console\controllers',
    'controllerMap' => [
        'fixture' => [
            'class' => 'yii\console\controllers\FixtureController',
            'namespace' => 'common\fixtures',
          ],
          'pplatp' => 'yii/console\controllers\PplAtpController',

    ],
    'components' => [
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'ppl-atp/index'
        ],
        'db' => [
			'class' => 'yii\db\Connection',
			'dsn' => 'pgsql:host=10.9.39.43;dbname=foro',
			'username' => 'postgres',
			'password' => 'Playmedia@2017',
			'charset' => 'utf8',
			'schemaMap' => [
				'pgsql'=> [
					'class'=>'yii\db\pgsql\Schema',
					'defaultSchema' => 'public'
				]
			]
		],
    ],
    'params' => $params,
];
