<aside class="main-sidebar">
    <section class="sidebar">

		<?php $arrItems = [] ;
		if(Yii::$app->user->can('/dashboard-os/index')) {
			array_push($arrItems,
				['label' => 'Dashboard', 'icon' => 'home', 'url' => ['/dashboard-os/index']]);
		}


       		if(Yii::$app->user->can('/os-outsource-personil/index') ||
				Yii::$app->user->can('/os-outsource-personil/indexverify') ||
				Yii::$app->user->can('/os-outsource-personil/indexapprove')||
				Yii::$app->user->can('/os-outsource-personil/indexoverview')||
				Yii::$app->user->can('/os-outsource-personil/indexlog') ||
				Yii::$app->user->can('/os-outsource-salary/index') ||
				Yii::$app->user->can('/os-outsource-salary/indexverify') ||
				Yii::$app->user->can('/os-outsource-salary/indexapprove') ||
				Yii::$app->user->can('/os-outsource-salary/indexoverview') ||
				Yii::$app->user->can('/os-outsource-salary/indexlog')||
				Yii::$app->user->can('/os-outsource-parameter/index') ||
				Yii::$app->user->can('/os-outsource-parameter/indexverify') ||
				Yii::$app->user->can('/os-outsource-parameter/indexapprove')) {
				$arrItemsChild1 = [];
				$arrItemsChild2 = [];


			    $arrItemsChild2 = [];
				if(Yii::$app->user->can('/os-outsource-personil/index'))
					array_push($arrItemsChild2, ['label' => yii::t('app','Input'), 'icon' => 'plus', 'url' => ['/os-outsource-personil/index']]);
				if(Yii::$app->user->can('/os-outsource-personil/indexverify'))
					array_push($arrItemsChild2, ['label' => yii::t('app','Verification'), 'icon' => 'eye', 'url' => ['/os-outsource-personil/indexverify']]);
				if(Yii::$app->user->can('/os-outsource-personil/indexapprove'))
					array_push($arrItemsChild2, ['label' => yii::t('app','Approval'), 'icon' => 'check-square-o', 'url' => ['/os-outsource-personil/indexapprove']]);
				if(Yii::$app->user->can('/os-outsource-personil/indexoverview'))
					array_push($arrItemsChild2, ['label' => yii::t('app','Overview'), 'icon' => 'list', 'url' => ['/os-outsource-personil/indexoverview']]);
				if(Yii::$app->user->can('/os-outsource-personil/indexlog'))
					array_push($arrItemsChild2, ['label' => yii::t('app','Log Historical'), 'icon' => 'list', 'url' => ['/os-outsource-personil/indexlog']]);

				if (Yii::$app->user->can('/os-outsource-personil/index') ||
				    Yii::$app->user->can('/os-outsource-personil/indexverify') ||
					Yii::$app->user->can('/os-outsource-personil/indexapprove')||
					Yii::$app->user->can('/os-outsource-personil/indexoverview')||
					Yii::$app->user->can('/os-outsource-personil/indexlog')) {
					array_push($arrItemsChild1, ['label' => 'Personil Registration', 'icon' => 'user-plus', 'url' => ['#'], 'items' => $arrItemsChild2]);
				}

				$arrItemsChild2 = [];
				if(Yii::$app->user->can('/os-outsource-salary/index'))
					array_push($arrItemsChild2, ['label' => yii::t('app','Input'), 'icon' => 'plus', 'url' => ['/os-outsource-salary/index']]);
				if(Yii::$app->user->can('/os-outsource-salary/indexverify'))
					array_push($arrItemsChild2, ['label' => yii::t('app','Verification'), 'icon' => 'eye', 'url' => ['/os-outsource-salary/indexverify']]);
				if(Yii::$app->user->can('/os-outsource-salary/indexapprove'))
					array_push($arrItemsChild2, ['label' => yii::t('app','Approval'), 'icon' => 'check-square-o', 'url' => ['/os-outsource-salary/indexapprove']]);
				if(Yii::$app->user->can('/os-outsource-salary/indexoverview'))
					array_push($arrItemsChild2, ['label' => yii::t('app','Overview'), 'icon' => 'list', 'url' => ['/os-outsource-salary/indexoverview']]);
				if(Yii::$app->user->can('/os-outsource-salary/indexlog'))
					array_push($arrItemsChild2, ['label' => yii::t('app','Log Historical'), 'icon' => 'list', 'url' => ['/os-outsource-salary/indexlog']]);

				if (Yii::$app->user->can('/os-outsource-salary/index') ||
					Yii::$app->user->can('/os-outsource-salary/indexverify') ||
					Yii::$app->user->can('/os-outsource-salary/indexapprove')||
					Yii::$app->user->can('/os-outsource-salary/indexoverview') ||
					Yii::$app->user->can('/os-outsource-salary/indexlog')) {
					array_push($arrItemsChild1, ['label' => 'Salary', 'icon' => 'calculator', 'url' => ['#'], 'items' => $arrItemsChild2]);
				}

				$arrItemsChild2 = [];
				if(Yii::$app->user->can('/os-outsource-parameter/index'))
					array_push($arrItemsChild2, ['label' => yii::t('app','Input'), 'icon' => 'plus', 'url' => ['/os-outsource-parameter/index']]);
				if(Yii::$app->user->can('/os-outsource-parameter/indexapprove'))
					array_push($arrItemsChild2, ['label' => yii::t('app','Approval'), 'icon' => 'check-square-o', 'url' => ['/os-outsource-parameter/indexapprove']]);

				if (Yii::$app->user->can('/os-outsource-parameter/index') ||
                   Yii::$app->user->can('/os-outsource-parameter/indexapprove')) {
					array_push($arrItemsChild1, ['label' => 'Salary Parameter', 'icon' => 'gear', 'url' => ['#'], 'items' => $arrItemsChild2]);
				}









				array_push($arrItems, ['label' => 'Outsource', 'icon' => 'user', 'url' => ['#'], 'items' => $arrItemsChild1]);
			}


			if(Yii::$app->user->can('/os-ga-biaya-jalan-osp/index') ||
				Yii::$app->user->can('/os-ga-biaya-jalan-osp/indexverify') ||
				Yii::$app->user->can('/os-ga-biaya-jalan-osp/indexapprove') ||
				Yii::$app->user->can('/os-ga-biaya-jalan-osp/indexoverview') ||
				Yii::$app->user->can('/os-ga-biaya-jalan-osp/indexlog') ||
				Yii::$app->user->can('/os-ga-biaya-jalan-iko/index') ||
				Yii::$app->user->can('/os-ga-biaya-jalan-iko/indexverify') ||
				Yii::$app->user->can('/os-ga-biaya-jalan-iko/indexapprove') ||
				Yii::$app->user->can('/os-ga-biaya-jalan-iko/indexoverview') ||
				Yii::$app->user->can('/os-ga-biaya-jalan-iko/indexlog') ||
				Yii::$app->user->can('/os-ga-vehicle-osp/index') ||
				Yii::$app->user->can('/os-ga-vehicle-osp/indexverify') ||
				Yii::$app->user->can('/os-ga-vehicle-osp/indexapprove') ||
                Yii::$app->user->can('/os-ga-vehicle-iko/index') ||
				Yii::$app->user->can('/os-ga-vehicle-iko/indexverify') ||
				Yii::$app->user->can('/os-ga-vehicle-iko/indexapprove') ||
				Yii::$app->user->can('/os-ga-vehicle-parameter/index') ||
				Yii::$app->user->can('/os-ga-vehicle-parameter/indexverify') ||
				Yii::$app->user->can('/os-ga-vehicle-parameter/indexapprove') ||
			    Yii::$app->user->can('/os-ga-driver-parameter/index') ||
				Yii::$app->user->can('/os-ga-driver-parameter/indexverify') ||
				Yii::$app->user->can('/os-ga-driver-parameter/indexapprove')) {
				$arrItemsChild1 = [];
				$arrItemsChild2 = [];

				$arrItemsChild2 = [];
				if(Yii::$app->user->can('/os-ga-vehicle-iko/indexwo'))
					array_push($arrItemsChild2, ['label' => yii::t('app','List WO'), 'icon' => 'list', 'url' => ['/os-ga-vehicle-iko/indexwo']]);
				if(Yii::$app->user->can('/os-ga-vehicle-iko/index'))
					array_push($arrItemsChild2, ['label' => yii::t('app','Input'), 'icon' => 'plus', 'url' => ['/os-ga-vehicle-iko/index']]);
				if(Yii::$app->user->can('/os-ga-vehicle-iko/indexverify'))
					array_push($arrItemsChild2, ['label' => yii::t('app','Verification'), 'icon' => 'eye', 'url' => ['/os-ga-vehicle-iko/indexverify']]);
				if(Yii::$app->user->can('/os-ga-vehicle-iko/indexapprove'))
					array_push($arrItemsChild2, ['label' => yii::t('app','Approval'), 'icon' => 'check-square-o', 'url' => ['/os-ga-vehicle-iko/indexapprove']]);
				if(Yii::$app->user->can('/os-ga-vehicle-iko/indexoverview'))
					array_push($arrItemsChild2, ['label' => yii::t('app','Overview'), 'icon' => 'list', 'url' => ['/os-ga-vehicle-iko/indexoverview']]);
				if(Yii::$app->user->can('/os-ga-vehicle-iko/indexlog'))
					array_push($arrItemsChild2, ['label' => yii::t('app','Log Historical'), 'icon' => 'list', 'url' => ['/os-ga-vehicle-iko/indexlog']]);

				if (Yii::$app->user->can('/os-ga-vehicle-iko/index') ||
					Yii::$app->user->can('/os-ga-vehicle-iko/indexverify') ||
					Yii::$app->user->can('/os-ga-vehicle-iko/indexapprove')||
					Yii::$app->user->can('/os-ga-vehicle-iko/indexoverview') ||
					Yii::$app->user->can('/os-ga-vehicle-iko/indexlog')) {
					array_push($arrItemsChild1, ['label' => 'Vehicle IKO', 'icon' => 'truck', 'url' => ['#'], 'items' => $arrItemsChild2]);
				}


				$arrItemsChild2 = [];
				if(Yii::$app->user->can('/os-ga-vehicle-osp/indexwo'))
					array_push($arrItemsChild2, ['label' => yii::t('app','List WO'), 'icon' => 'list', 'url' => ['/os-ga-vehicle-osp/indexwo']]);
				if(Yii::$app->user->can('/os-ga-vehicle-osp/index'))
					array_push($arrItemsChild2, ['label' => yii::t('app','Input'), 'icon' => 'plus', 'url' => ['/os-ga-vehicle-osp/index']]);
				if(Yii::$app->user->can('/os-ga-vehicle-osp/indexverify'))
					array_push($arrItemsChild2, ['label' => yii::t('app','Verification'), 'icon' => 'eye', 'url' => ['/os-ga-vehicle-osp/indexverify']]);
				if(Yii::$app->user->can('/os-ga-vehicle-osp/indexapprove'))
					array_push($arrItemsChild2, ['label' => yii::t('app','Approval'), 'icon' => 'check-square-o', 'url' => ['/os-ga-vehicle-osp/indexapprove']]);
				if(Yii::$app->user->can('/os-ga-vehicle-osp/indexoverview'))
					array_push($arrItemsChild2, ['label' => yii::t('app','Overview'), 'icon' => 'list', 'url' => ['/os-ga-vehicle-osp/indexoverview']]);
				if(Yii::$app->user->can('/os-ga-vehicle-osp/indexlog'))
					array_push($arrItemsChild2, ['label' => yii::t('app','Log Historical'), 'icon' => 'list', 'url' => ['/os-ga-vehicle-osp/indexlog']]);

				if (Yii::$app->user->can('/os-ga-vehicle-osp/index') ||
					Yii::$app->user->can('/os-ga-vehicle-osp/indexverify') ||
					Yii::$app->user->can('/os-ga-vehicle-osp/indexapprove') ||
					Yii::$app->user->can('/os-ga-vehicle-osp/indexoverview') ||
					Yii::$app->user->can('/os-ga-vehicle-osp/indexlog')) {
					array_push($arrItemsChild1, ['label' => 'Vehicle OSP', 'icon' => 'truck', 'url' => ['#'], 'items' => $arrItemsChild2]);
				}

				
				$arrItemsChild2 = [];
				if(Yii::$app->user->can('/os-ga-biaya-jalan-iko/index'))
					array_push($arrItemsChild2, ['label' => yii::t('app','Input'), 'icon' => 'plus', 'url' => ['/os-ga-biaya-jalan-iko/index']]);
				if(Yii::$app->user->can('/os-ga-biaya-jalan-iko/indexverify'))
					array_push($arrItemsChild2, ['label' => yii::t('app','Verification'), 'icon' => 'eye', 'url' => ['/os-ga-biaya-jalan-iko/indexverify']]);
				if(Yii::$app->user->can('/os-ga-biaya-jalan-iko/indexapprove'))
					array_push($arrItemsChild2, ['label' => yii::t('app','Approval'), 'icon' => 'check-square-o', 'url' => ['/os-ga-biaya-jalan-iko/indexapprove']]);
				if(Yii::$app->user->can('/os-ga-biaya-jalan-iko/indexoverview'))
					array_push($arrItemsChild2, ['label' => yii::t('app','Overview'), 'icon' => 'list', 'url' => ['/os-ga-biaya-jalan-iko/indexoverview']]);
				if(Yii::$app->user->can('/os-ga-biaya-jalan-iko/indexlog'))
					array_push($arrItemsChild2, ['label' => yii::t('app','Log Historical'), 'icon' => 'list', 'url' => ['/os-ga-biaya-jalan-iko/indexlog']]);

				if (Yii::$app->user->can('/os-ga-biaya-jalan-iko/index') ||
				    Yii::$app->user->can('/os-ga-biaya-jalan-iko/indexverify') ||
					Yii::$app->user->can('/os-ga-biaya-jalan-iko/indexapprove')) {
					array_push($arrItemsChild1, ['label' => 'Operational Cost IKO ', 'icon' => 'calculator', 'url' => ['#'], 'items' => $arrItemsChild2]);
				}


			    $arrItemsChild2 = [];
				if(Yii::$app->user->can('/os-ga-biaya-jalan-osp/index'))
					array_push($arrItemsChild2, ['label' => yii::t('app','Input'), 'icon' => 'plus', 'url' => ['/os-ga-biaya-jalan-osp/index']]);
				if(Yii::$app->user->can('/os-ga-biaya-jalan-osp/indexverify'))
					array_push($arrItemsChild2, ['label' => yii::t('app','Verification'), 'icon' => 'eye', 'url' => ['/os-ga-biaya-jalan-osp/indexverify']]);
				if(Yii::$app->user->can('/os-ga-biaya-jalan-osp/indexapprove'))
					array_push($arrItemsChild2, ['label' => yii::t('app','Approval'), 'icon' => 'check-square-o', 'url' => ['/os-ga-biaya-jalan-osp/indexapprove']]);
				if(Yii::$app->user->can('/os-ga-biaya-jalan-osp/indexoverview'))
					array_push($arrItemsChild2, ['label' => yii::t('app','Overview'), 'icon' => 'list', 'url' => ['/os-ga-biaya-jalan-osp/indexoverview']]);
				if(Yii::$app->user->can('/os-ga-biaya-jalan-osp/indexlog'))
					array_push($arrItemsChild2, ['label' => yii::t('app','Log Historical'), 'icon' => 'list', 'url' => ['/os-ga-biaya-jalan-osp/indexlog']]);

				if (Yii::$app->user->can('/os-ga-biaya-jalan-osp/index') ||
				    Yii::$app->user->can('/os-ga-biaya-jalan-osp/indexverify') ||
					Yii::$app->user->can('/os-ga-biaya-jalan-osp/indexapprove') ||
				Yii::$app->user->can('/os-ga-biaya-jalan-osp/indexoverview') ||
				Yii::$app->user->can('/os-ga-biaya-jalan-osp/indexlog') ) {
					array_push($arrItemsChild1, ['label' => 'Operational Cost OSP ', 'icon' => 'calculator', 'url' => ['#'], 'items' => $arrItemsChild2]);
				}



				$arrItemsChild2 = [];
				if(Yii::$app->user->can('/os-ga-vehicle-parameter/index'))
					array_push($arrItemsChild2, ['label' => yii::t('app','Input'), 'icon' => 'plus', 'url' => ['/os-ga-vehicle-parameter/index']]);
				if(Yii::$app->user->can('/os-ga-vehicle-parameter/indexapprove'))
					array_push($arrItemsChild2, ['label' => yii::t('app','Approval'), 'icon' => 'check-square-o', 'url' => ['/os-ga-vehicle-parameter/indexapprove']]);

				if (Yii::$app->user->can('/os-ga-vehicle-parameter/index') ||
                   Yii::$app->user->can('/os-ga-vehicle-parameter/indexverify') ||
                   Yii::$app->user->can('/os-ga-vehicle-parameter/indexapprove')) {
					array_push($arrItemsChild1, ['label' => 'Vehicle Parameter', 'icon' => 'gear', 'url' => ['#'], 'items' => $arrItemsChild2]);
				}


				$arrItemsChild2 = [];
				if(Yii::$app->user->can('/os-ga-driver-parameter/index'))
					array_push($arrItemsChild2, ['label' => yii::t('app','Input'), 'icon' => 'plus', 'url' => ['/os-ga-driver-parameter/index']]);

				if(Yii::$app->user->can('/os-ga-driver-parameter/indexapprove'))
					array_push($arrItemsChild2, ['label' => yii::t('app','Approval'), 'icon' => 'check-square-o', 'url' => ['/os-ga-driver-parameter/indexapprove']]);

				if (Yii::$app->user->can('/os-ga-driver-parameter/index') ||
                   Yii::$app->user->can('/os-ga-driver-parameter/indexverify') ||
                   Yii::$app->user->can('/os-ga-driver-parameter/indexapprove')) {
					array_push($arrItemsChild1, ['label' => 'Driver Parameter', 'icon' => 'gear', 'url' => ['#'], 'items' => $arrItemsChild2]);
				}



				array_push($arrItems, ['label' => 'General Affair', 'icon' => 'truck', 'url' => ['#'], 'items' => $arrItemsChild1]);
			}

			if(Yii::$app->user->can('/os-vendor-regist-vendor/index') ||
				Yii::$app->user->can('/os-vendor-regist-vendor/indexverify') ||
				Yii::$app->user->can('/os-vendor-regist-vendor/indexapprove') ||
				Yii::$app->user->can('/os-vendor-regist-vendor/indexoverview') ||
				Yii::$app->user->can('/os-vendor-pob/index') ||
				Yii::$app->user->can('/os-vendor-pob/indexverify') ||
				Yii::$app->user->can('/os-vendor-pob/indexapprove') ||
				Yii::$app->user->can('/os-vendor-pob/indexoverview') ||
				Yii::$app->user->can('/os-vendor-pob/indexlog') ||
				Yii::$app->user->can('/os-vendor-pob-detail/index') ||
				Yii::$app->user->can('/os-vendor-pob-detail/indexverify') ||
				Yii::$app->user->can('/os-vendor-pob-detail/indexapprove') ||
			    Yii::$app->user->can('/os-vendor-term-sheet/index') ||
				Yii::$app->user->can('/os-vendor-term-sheet/indexverify') ||
				Yii::$app->user->can('/os-vendor-term-sheet/indexapprove') ||
				Yii::$app->user->can('/os-vendor-term-sheet/indexoverview') ||
				Yii::$app->user->can('/os-vendor-term-sheet/indexlog')) {
				$arrItemsChild1 = [];
				$arrItemsChild2 = [];



				if(Yii::$app->user->can('/os-vendor-regist-vendor/index'))
					array_push($arrItemsChild2, ['label' => yii::t('app','Input'), 'icon' => 'plus', 'url' => ['/os-vendor-regist-vendor/index']]);
				if(Yii::$app->user->can('/os-vendor-regist-vendor/indexverify'))
					array_push($arrItemsChild2, ['label' => yii::t('app','Verification'), 'icon' => 'eye', 'url' => ['/os-vendor-regist-vendor/indexverify']]);
				if(Yii::$app->user->can('/os-vendor-regist-vendor/indexapprove'))
					array_push($arrItemsChild2, ['label' => yii::t('app','Approval'), 'icon' => 'check-square-o', 'url' => ['/os-vendor-regist-vendor/indexapprove']]);
				if(Yii::$app->user->can('/os-vendor-regist-vendor/indexoverview'))
					array_push($arrItemsChild2, ['label' => yii::t('app','Overview'), 'icon' => 'check-square-o', 'url' => ['/os-vendor-regist-vendor/indexoverview']]);
				if(Yii::$app->user->can('/os-vendor-regist-vendor/indexlog'))
					array_push($arrItemsChild2, ['label' => yii::t('app','Log Historical'), 'icon' => 'check-square-o', 'url' => ['/os-vendor-regist-vendor/indexlog']]);

				if (Yii::$app->user->can('/os-vendor-regist-vendor/index') ||
				    Yii::$app->user->can('/os-vendor-regist-vendor/indexverify') ||
					Yii::$app->user->can('/os-vendor-regist-vendor/indexapprove') ||
					Yii::$app->user->can('/os-vendor-regist-vendor/indexoverview') ||
					Yii::$app->user->can('/os-vendor-regist-vendor/indexlog')) {
					array_push($arrItemsChild1, ['label' => 'Vendor Registration', 'icon' => 'user-plus', 'url' => ['#'], 'items' => $arrItemsChild2]);
				}



				$arrItemsChild2 = [];
				if(Yii::$app->user->can('/os-vendor-term-sheet/index'))
					array_push($arrItemsChild2, ['label' => yii::t('app','Input'), 'icon' => 'plus', 'url' => ['/os-vendor-term-sheet/index']]);
				if(Yii::$app->user->can('/os-vendor-term-sheet/indexverify'))
					array_push($arrItemsChild2, ['label' => yii::t('app','Verification'), 'icon' => 'eye', 'url' => ['/os-vendor-term-sheet/indexverify']]);
				if(Yii::$app->user->can('/os-vendor-term-sheet/indexapprove'))
					array_push($arrItemsChild2, ['label' => yii::t('app','Approval'), 'icon' => 'check-square-o', 'url' => ['/os-vendor-term-sheet/indexapprove']]);
				if(Yii::$app->user->can('/os-vendor-term-sheet/indexoverview'))
					array_push($arrItemsChild2, ['label' => yii::t('app','Overview'), 'icon' => 'check-square-o', 'url' => ['/os-vendor-term-sheet/indexoverview']]);
				if(Yii::$app->user->can('/os-vendor-term-sheet/indexlog'))
					array_push($arrItemsChild2, ['label' => yii::t('app','Log Historical'), 'icon' => 'check-square-o', 'url' => ['/os-vendor-term-sheet/indexlog']]);

				if (Yii::$app->user->can('/os-vendor-term-sheet/index') ||
					Yii::$app->user->can('/os-vendor-term-sheet/indexverify') ||
					Yii::$app->user->can('/os-vendor-term-sheet/indexapprove') ||
					Yii::$app->user->can('/os-vendor-term-sheet/indexoverview') ||
					Yii::$app->user->can('/os-vendor-term-sheet/indexlog')) {
					array_push($arrItemsChild1, ['label' => 'Vendor Term Sheet', 'icon' => 'paste', 'url' => ['#'], 'items' => $arrItemsChild2]);
				}

				$arrItemsChild2 = [];
				if(Yii::$app->user->can('/os-vendor-pob/index'))
					array_push($arrItemsChild2, ['label' => yii::t('app','Input'), 'icon' => 'plus', 'url' => ['/os-vendor-pob/index']]);
				if(Yii::$app->user->can('/os-vendor-pob/indexverify'))
					array_push($arrItemsChild2, ['label' => yii::t('app','Verification'), 'icon' => 'eye', 'url' => ['/os-vendor-pob/indexverify']]);
				if(Yii::$app->user->can('/os-vendor-pob/indexapprove'))
					array_push($arrItemsChild2, ['label' => yii::t('app','Approval'), 'icon' => 'check-square-o', 'url' => ['/os-vendor-pob/indexapprove']]);
				if(Yii::$app->user->can('/os-vendor-pob/indexoverview'))
					array_push($arrItemsChild2, ['label' => yii::t('app','Overview'), 'icon' => 'check-square-o', 'url' => ['/os-vendor-pob/indexoverview']]);
				if(Yii::$app->user->can('/os-vendor-pob/indexlog'))
					array_push($arrItemsChild2, ['label' => yii::t('app','Log Historical'), 'icon' => 'check-square-o', 'url' => ['/os-vendor-pob/indexlog']]);

				if (Yii::$app->user->can('/os-vendor-pob/index') ||
                   Yii::$app->user->can('/os-vendor-pob/indexverify') ||
                   Yii::$app->user->can('/os-vendor-pob/indexapprove') ||
                   Yii::$app->user->can('/os-vendor-pob/indexoverview') ||
                   Yii::$app->user->can('/os-vendor-pob/indexlog')) {
					array_push($arrItemsChild1, ['label' => 'Vendor PO Blanket', 'icon' => 'file-text', 'url' => ['#'], 'items' => $arrItemsChild2]);
				}

				$arrItemsChild2 = [];
				if(Yii::$app->user->can('/os-vendor-project-parameter/index'))
					array_push($arrItemsChild2, ['label' => yii::t('app','Input'), 'icon' => 'plus', 'url' => ['/os-vendor-project-parameter/index']]);
				// if(Yii::$app->user->can('/os-vendor-project-parameter/indexverify'))
					// array_push($arrItemsChild2, ['label' => yii::t('app','Verification'), 'icon' => 'eye', 'url' => ['/os-vendor-project-parameter/indexverify']]);
				if(Yii::$app->user->can('/os-vendor-project-parameter/indexapprove'))
					array_push($arrItemsChild2, ['label' => yii::t('app','Approval'), 'icon' => 'check-square-o', 'url' => ['/os-vendor-project-parameter/indexapprove']]);

				if (Yii::$app->user->can('/os-vendor-project-parameter/index') ||
                   Yii::$app->user->can('/os-vendor-project-parameter/indexverify') ||
                   Yii::$app->user->can('/os-vendor-project-parameter/indexapprove')) {
					array_push($arrItemsChild1, ['label' => 'Project Parameter', 'icon' => 'file-text', 'url' => ['#'], 'items' => $arrItemsChild2]);
				}


				array_push($arrItems, ['label' => 'Vendor', 'icon' => 'briefcase', 'url' => ['#'], 'items' => $arrItemsChild1]);
			}


				// array_push($arrItems, ['label' => 'Project Setting', 'icon' => 'check-square-o', 'url' => ['/os-vendor-project-parameter/index']]);



			echo dmstr\widgets\Menu::widget(
				[
					'options' => ['class' => 'sidebar-menu'],
					'items' => $arrItems
				]
			)
		?>


    </section>
</aside>
