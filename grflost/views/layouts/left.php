<aside class="main-sidebar">
    <section class="sidebar">

		<?php $arrItems = [] ;
		if(Yii::$app->user->can('/dashboard-ca/index')) {
			array_push($arrItems,
				['label' => 'Dashboard', 'icon' => 'home', 'url' => ['/dashboard-ca/index']]);
		}
			
		// if(Yii::$app->user->can('/ca-iom-area-expansion/index') || Yii::$app->user->can('/ca-iom-area-expansion/indexverify') || 
			// Yii::$app->user->can('/ca-iom-area-expansion/indexapprove') || Yii::$app->user->can('/ca-iom-area-expansion/indexoverview')) {	
				$arrItemsChild = [];
				$arrItemsParent = [];
				// if(Yii::$app->user->can('/ca-iom-area-expansion/index'))
					array_push($arrItemsChild, ['label' => yii::t('app','Input'), 'icon' => 'plus', 'url' => ['/grf/index']]);
					array_push($arrItemsChild, ['label' => yii::t('app','Verification'), 'icon' => 'eye', 'url' => ['/grf/indexverify']]);
				
				// if(Yii::$app->user->can('/ca-iom-area-expansion/indexapprove'))
					array_push($arrItemsChild, ['label' => yii::t('app','Approval'), 'icon' => 'check-square-o', 'url' => ['/grf/indexapprove']]);

					array_push($arrItemsChild, ['label' => yii::t('app','MR Peminjaman'), 'icon' => 'plus', 'url' => ['/grf/indexmr']]);
				
				
				array_push($arrItemsParent, ['label' => 'IKR', 'icon' => 'balance-scale', 'url' => ['#'], 'items' => $arrItemsChild]);	

				array_push($arrItems, ['label' => 'GRF', 'icon' => 'balance-scale', 'url' => ['#'], 'items' => $arrItemsParent]);	




				// $arrItemsChild = [];
				$arrItemsParent = [];
				// if(Yii::$app->user->can('/ca-iom-area-expansion/index'))
					

					array_push($arrItemsParent, ['label' => yii::t('app','Input'), 'icon' => 'plus', 'url' => ['/grf/indexothers']]);

					array_push($arrItemsParent, ['label' => yii::t('app','Verification'), 'icon' => 'plus', 'url' => ['/grf/indexothersverify']]);

					array_push($arrItemsParent, ['label' => yii::t('app','Approve'), 'icon' => 'plus', 'url' => ['/grf/indexothersapprove']]);
				
				// if(Yii::$app->user->can('/ca-iom-area-expansion/indexapprove'))
					// array_push($arrItemsParent, ['label' => yii::t('app','Approval'), 'icon' => 'check-square-o', 'url' => ['/grf/indexapprove']]);
					

				array_push($arrItems, ['label' => 'Others', 'icon' => 'balance-scale', 'url' => ['#'], 'items' => $arrItemsParent]);
			// }
	
			
			
		// if(Yii::$app->user->can('/region/index') || Yii::$app->user->can('/city/indexverify') || 
			// Yii::$app->user->can('/district/indexapprove') || Yii::$app->user->can('/subdistrict/indexapprove')){

			// $arrItemsChild_0 = [];

			// if(Yii::$app->user->can('/region/index'))
					// array_push($arrItemsChild_0, ['label' => yii::t('app','Region'), 'icon' => 'legal', 'url' => ['/region/index']]);
			// if(Yii::$app->user->can('/city/index'))
					// array_push($arrItemsChild_0, ['label' => yii::t('app','City'), 'icon' => 'legal', 'url' => ['/city/index']]);
			// if(Yii::$app->user->can('/district/index'))
					// array_push($arrItemsChild_0, ['label' => yii::t('app','District'), 'icon' => 'legal', 'url' => ['/district/index']]);
			// if(Yii::$app->user->can('/subdistrict/index'))
					// array_push($arrItemsChild_0, ['label' => yii::t('app','Subdistrict'), 'icon' => 'archive', 'url' => ['/subdistrict/index']]);

			// array_push($arrItems, ['label' => 'Area Setting', 'icon' => 'cog', 'url' => ['#'], 'items' => $arrItemsChild_0]);

		// }	
			
		// if(Yii::$app->user->can('/ca-reference/index'))
				// array_push($arrItems, ['label' => yii::t('app','Parameter Setting'), 'icon' => 'legal', 'url' => ['/ca-reference/index']]);
		
		

			
			
			echo dmstr\widgets\Menu::widget(
				[
					'options' => ['class' => 'sidebar-menu'],
					'items' => $arrItems
				]
			) 
		?>


    </section>
</aside>
