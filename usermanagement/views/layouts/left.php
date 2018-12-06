<aside class="main-sidebar">

    <section class="sidebar">

        <?php
			$arrItemsChild3 = [];
			if(Yii::$app->user->can('/email-parameter/index'))
				array_push($arrItemsChild3, ['label' => yii::t('app','Email Parameter'), 'icon' => 'envelope', 'url' => ['/email-parameter/index']]);

			$arrItemsChild2 = [];
			if(Yii::$app->user->can('/govrel-par-bbfeed-permit/index'))
				array_push($arrItemsChild2, ['label' => yii::t('app','Input'), 'icon' => 'plus', 'url' => ['/govrel-par-bbfeed-permit/index']]);
			if(Yii::$app->user->can('/govrel-par-bbfeed-permit/indexapprove'))
				array_push($arrItemsChild2, ['label' => yii::t('app','Approval'), 'icon' => 'check-square-o', 'url' => ['/govrel-par-bbfeed-permit/indexapprove']]);

			$arrItemsChild1 = [];
			if(Yii::$app->user->can('/govrel-parameter-pic-problem/index'))
				array_push($arrItemsChild1, ['label' => yii::t('app','Input'), 'icon' => 'plus', 'url' => ['/govrel-parameter-pic-problem/index']]);
			if(Yii::$app->user->can('/govrel-parameter-pic-problem/indexapprove'))
				array_push($arrItemsChild1, ['label' => yii::t('app','Approval'), 'icon' => 'check-square-o', 'url' => ['/govrel-parameter-pic-problem/indexapprove']]);

			$arrItemsChild = [];
			if(Yii::$app->user->can('/govrel-parameter-reminder/index'))
				array_push($arrItemsChild, ['label' => yii::t('app','Reminder Day'), 'icon' => 'check-square-o', 'url' => ['/govrel-parameter-reminder/index']]);
		?>

        <?= dmstr\widgets\Menu::widget(
            // [
            //     'options' => ['class' => 'sidebar-menu'],
            //     'items' => [
            //         ['label' => 'Menu Yii2', 'options' => ['class' => 'header']],
            //         ['label' => 'Gii', 'icon' => 'fa fa-file-code-o', 'url' => ['/gii']],
            //         ['label' => 'Debug', 'icon' => 'fa fa-dashboard', 'url' => ['/debug']],
            //         ['label' => 'Login', 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest],
            //         [
            //             'label' => 'Same tools',
            //             'icon' => 'fa fa-share',
            //             'url' => '#',
            //             'items' => [
            //                 ['label' => 'Gii', 'icon' => 'fa fa-file-code-o', 'url' => ['/gii'],],
            //                 ['label' => 'Debug', 'icon' => 'fa fa-dashboard', 'url' => ['/debug'],],
            //                 [
            //                     'label' => 'Level One',
            //                     'icon' => 'fa fa-circle-o',
            //                     'url' => '#',
            //                     'items' => [
            //                         ['label' => 'Level Two', 'icon' => 'fa fa-circle-o', 'url' => '#',],
            //                         [
            //                             'label' => 'Level Two',
            //                             'icon' => 'fa fa-circle-o',
            //                             'url' => '#',
            //                             'items' => [
            //                                 ['label' => 'Level Three', 'icon' => 'fa fa-circle-o', 'url' => '#',],
            //                                 ['label' => 'Level Three', 'icon' => 'fa fa-circle-o', 'url' => '#',],
            //                             ],
            //                         ],
            //                     ],
            //                 ],
            //             ],
            //         ],
            //     ],
            // ]
            [
                'options' => ['class' => 'sidebar-menu'],
                'items' => [

                    ['label' => 'User Management', 'icon' => 'fa fa-user-o', 'url' => ['#'],
                        'items' => [
                            ['label' => 'Create User', 'icon' => 'fa fa-circle-o', 'url' => ['/admin/user/signup'],],
                           // ['label' => 'Assignment', 'icon' => 'fa fa-circle-o', 'url' => ['/auth_assignment/index'],],
                            ['label' => 'Role', 'icon' => 'fa fa-circle-o', 'url' => ['/auth_item/index'],],
                            ['label' => 'Users', 'icon' => 'fa fa-circle-o', 'url' => ['/admin/user'],],
							['label' => 'Branch Setting', 'icon' => 'fa fa-circle-o', 'url' => ['/branch/index'],],
							['label' => 'Labor Setting', 'icon' => 'fa fa-circle-o', 'url' => ['/labor/index'],],
                        ],
                    ],
					['label' => 'CA Setting', 'icon' => 'cog', 'url' => ['#'],
                        'items' => [
                            ['label' => yii::t('app','Region Setting'), 'icon' => 'legal', 'url' => ['/region/index']],
                            ['label' => yii::t('app','City Setting'), 'icon' => 'legal', 'url' => ['/city/index']],
                            ['label' => yii::t('app','District Setting'), 'icon' => 'legal', 'url' => ['/district/index']],
							['label' => yii::t('app','Subdistrict Setting'), 'icon' => 'archive', 'url' => ['/subdistrict/index']],
							['label' => yii::t('app','CA Parameter Setting'), 'icon' => 'legal', 'url' => ['/ca-reference/index']]
                        ],
                    ],

					['label' => 'Parameter Setting', 'icon' => 'user-plus', 'url' => ['#'],
						'items' => [
							['label' => 'GOVREL PIC BB Feeder Permit', 'icon' => 'user-plus', 'url' => ['#'], 'items' => $arrItemsChild2],
							['label' => 'GOVREL PIC Problem', 'icon' => 'user-plus', 'url' => ['#'], 'items' => $arrItemsChild1],
							['label' => 'Reminder Day', 'icon' => 'user-plus', 'url' => ['#'], 'items' => $arrItemsChild ],
							['label' => 'Email', 'icon' => 'envelope', 'url' => ['#'], 'items' => $arrItemsChild3 ],
						],
					],
					
					['label'=>'Manage Warehouse', 'icon' => 'fa fa-circle-o', 'url'=>['warehouse/index']]

                ],
            ]
        ) ?>

    </section>

</aside>
