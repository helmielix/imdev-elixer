<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-divisitiga',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'divisitiga\controllers',
    'bootstrap' => ['log'],
    'modules' => [],
	'homeUrl' => '/divisitiga/',
    'components' => [
		'formatter' => [
			'class' => 'yii\i18n\Formatter',
			'nullDisplay' => '-',
		],
        'request' => [
            'csrfParam' => '_csrf-divisitiga',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-divisitiga', 'httpOnly' => true],
        ],
        'session' => [
            'name' => 'divisitiga',
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
			'showScriptName' => false,
			'rules' => [
				'' => 'dashboard-divisitiga/index',                                
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
			'site/*',
			'gii/*',
        ]
    ],
    'params' => $params,
];
