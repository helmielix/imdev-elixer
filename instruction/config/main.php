<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-instruction',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'instruction\controllers',
    'bootstrap' => ['log'],
    'modules' => [],
	'homeUrl' => '/instruction/',
    'components' => [
		'formatter' => [
			'class' => 'yii\i18n\Formatter',
			'nullDisplay' => '-',
		],
        'request' => [
            'csrfParam' => '_csrf-inbound',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-instruction', 'httpOnly' => true],
        ],
        'session' => [
            'name' => 'instruction',
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
				'' => 'dashboard-instruction/index',                                
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
