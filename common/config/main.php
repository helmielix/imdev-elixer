<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
		'formatter' => [
			'class' => 'yii\i18n\Formatter',
			'nullDisplay' => '-',
            // 'defaultTimeZone' => 'Asia/Jakarta',
            'defaultTimeZone' => 'Europe/Berlin', // server 43 MNC
		],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
         'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'user' => [
            'identityClass' => 'mdm\admin\models\User',
            'loginUrl' => ['site/login'],
			'enableAutoLogin' => false,
			'authTimeout' => 3000,
        ],
    ],
    'modules' => [
        'gii' => [
            'class' => 'yii\gii\Module',
            'allowedIPs' => ['*'],
        ],
        'admin' => [
            'class' => 'mdm\admin\Module',
        ],
		'gridview' => ['class' => 'kartik\grid\Module']
    ],
    'as access' => [
        'class' => 'mdm\admin\components\AccessControl',
        'allowActions' => [
            'site/*',
            'gii/*',
            'admin/route/*',
            'admin/role/*',
            
            'parameter-master-item/*',
			// '*'
        ]
    ],
];
