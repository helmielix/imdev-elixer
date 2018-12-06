<?php
return [
    'components' => [

		'db' => [
			'class' => 'yii\db\Connection',
			// 'dsn' => 'pgsql:host=10.9.38.46;dbname=inventory',
			'dsn' => 'pgsql:host=localhost;dbname=inventory',
			'username' => 'postgres',
			'password' => 'postgres',
			// 'password' => '@Admin123',
			 // 'password' => 'Playmedia@2018',
			'charset' => 'utf8',
			'schemaMap' => [
				'pgsql'=> [
					'class'=>'yii\db\pgsql\Schema',
					'defaultSchema' => 'public'
				]
			]
		],

        'dbim' => [
            'class' => 'yii\db\Connection',
			'dsn' => 'mysql:host=10.9.45.10;dbname=incident_manager',
			'username' => 'elixeraccess',
			'password' => 'ElixerAccez@2018',
			'charset' => 'utf8',
        ],

        // 'dborafin' => [
        //     'class' => 'apaoww\oci8\Oci8DbConnection',
        //     // 'class' => 'yii\db\Connection',
        //     // 'dsn' => 'oci8:dbname=//172.17.20.193:1540/mkmdev01',
        //     'dsn' => 'oci8:dbname=(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST=172.17.20.193)(PORT=1540))(CONNECT_DATA=(SID=xe)));charset=AL32UTF8;',
        //     // 'dsn' => 'oci8:dbname=(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST=172.17.20.193)(PORT=1540))(CONNECT_DATA=(SERVICE_NAME=mkmdev01)));',
        //     'username'=>'XMNC',
        //     'password'=>'XMNC',
        //     'attributes' => [],
        //     // 'enableSchemaCache' => true, //increase performance when retrieved table meta data
        //     // 'schemaCacheDuration' => 3600,
        //     // 'schemaCache' => 'cache',
        // ],

        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
			'useFileTransport' => true,
			'transport' => [
				'class' => 'Swift_SmtpTransport',
				'host' => 'mail2.mncplaymedia.com',
				'username' => 'foro@mail2.mncplaymedia.com',
				'password' => 'FoRo$2017',
				'port' => '587',
				'encryption' => 'tls',
			],
        ],
    ],
];
