<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

$params['maskMoneyOptions'] = [
            'prefix' => 'US$ ',
            'suffix' => '',
            'affixesStay' => true,
            'thousands' => ',',
            'decimal' => '.',
            'precision' => 0,
            'allowZero' => false,
            'allowNegative' => false,
        ];

return [
    'id' => 'app-oci',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'oci\controllers',
    'bootstrap' => ['log'],
    'modules' => [],
	'homeUrl' => '/foro/',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-oci',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ],
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-foro', 'httpOnly' => true],
        ],
        'session' => [
            'name' => 'foro',
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
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
		'urlManager' => [
			'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
			'showScriptName' => false,
			'rules' => [
				'' => 'dashboard-oci/index',
                'class' => 'yii\rest\UrlRule',
                'controller' => 'apiorafin',
				'<controller:\w+>/<action:\w+>/' => '<controller>/<action>',
			],
		],

        'authManager' =>
            [
                'class' => 'yii\rbac\DbManager',
                'defaultRoles' => ['guest'],
            ],

    ],
    'as access' => [
        'class' => 'mdm\admin\components\AccessControl',
        'allowActions' => [
        	'dashboard-oci/index',
			'gii/*',
            'apiorafin/*',
        ]
    ],
   'params' => $params,

];
