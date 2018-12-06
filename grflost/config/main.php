<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-grflost',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'grflost\controllers',
    'bootstrap' => ['log'],
    'modules' => [],
	'homeUrl' => '/im/',
    'components' => [
		'formatter' => [
			'class' => 'yii\i18n\Formatter',
			'nullDisplay' => '-',
		],
        'request' => [
            'csrfParam' => '_csrf-grflost',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-grflost', 'httpOnly' => true],
        ],
        'session' => [
            'name' => 'grflost',
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
				'' => 'dashboard-grflost/index',                                
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
