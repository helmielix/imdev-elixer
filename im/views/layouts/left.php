<aside class="main-sidebar">
    <section class="sidebar">

		<?php $arrItems = [] ;
		if(Yii::$app->user->can('/dashboard-ca/index')) {
			array_push($arrItems,
				['label' => 'Dashboard', 'icon' => 'home', 'url' => ['/dashboard-ca/index']]);
		}
			
		if(Yii::$app->user->can('/ca-iom-area-expansion/index') || Yii::$app->user->can('/ca-iom-area-expansion/indexverify') || 
			Yii::$app->user->can('/ca-iom-area-expansion/indexapprove') || Yii::$app->user->can('/ca-iom-area-expansion/indexoverview')) {	
				$arrItemsChild = [];
				if(Yii::$app->user->can('/ca-iom-area-expansion/index'))
					array_push($arrItemsChild, ['label' => yii::t('app','Input'), 'icon' => 'plus', 'url' => ['/ca-iom-area-expansion/index']]);
				if(Yii::$app->user->can('/ca-iom-area-expansion/indexverify'))
					array_push($arrItemsChild, ['label' => yii::t('app','Verification'), 'icon' => 'eye', 'url' => ['/ca-iom-area-expansion/indexverify']]);
				if(Yii::$app->user->can('/ca-iom-area-expansion/indexapprove'))
					array_push($arrItemsChild, ['label' => yii::t('app','Approval'), 'icon' => 'check-square-o', 'url' => ['/ca-iom-area-expansion/indexapprove']]);
				if(Yii::$app->user->can('/ca-iom-area-expansion/indexoverview')){
					array_push($arrItemsChild, ['label' => yii::t('app','Data Overview'), 'icon' => 'list', 'url' => ['/ca-iom-area-expansion/indexoverview']]);
					array_push($arrItemsChild, ['label' => yii::t('app','Log History'), 'icon' => 'list', 'url' => ['/ca-iom-area-expansion/indexlog']]);
					//array_push($arrItemsChild, ['label' => yii::t('app','Log History City'), 'icon' => 'list', 'url' => ['/ca-iom-area-expansion/indexcitylog']]);
				}
					
				array_push($arrItems, ['label' => 'Manage City', 'icon' => 'balance-scale', 'url' => ['#'], 'items' => $arrItemsChild]);	
			}
			
		if(Yii::$app->user->can('/ca-ba-survey/index_presurvey') || Yii::$app->user->can('/ca-ba-survey/indexverify_presurvey') ||  
			Yii::$app->user->can('/ca-ba-survey/indexapprove_presurvey') || Yii::$app->user->can('/ca-ba-survey/index') || Yii::$app->user->can('/ca-ba-survey/indexverify') ||  
			Yii::$app->user->can('/ca-ba-survey/indexapprove') || Yii::$app->user->can('/ca-ba-survey/index_iom') || 
			Yii::$app->user->can('/ca-ba-survey/indexverify_iom') || Yii::$app->user->can('/ca-ba-survey/indexapprove_iom') || 
			Yii::$app->user->can('/ca-ba-survey/indexoverview') || Yii::$app->user->can('/homepass/index')){
			$arrItemsChild_p = [];
			$arrItemsChild_a = [];
			$arrItemsChild_b = [];
			$arrItemsChild_0 = [];
			
			if(Yii::$app->user->can('/ca-ba-survey/index_presurvey'))
					array_push($arrItemsChild_p, ['label' => yii::t('app','Input'), 'icon' => 'plus', 'url' => ['/ca-ba-survey/index_presurvey']]);

			if(Yii::$app->user->can('/ca-ba-survey/indexverify_presurvey'))
					array_push($arrItemsChild_p, ['label' => yii::t('app','Verification'), 'icon' => 'eye', 'url' => ['/ca-ba-survey/indexverify_presurvey']]);

			if(Yii::$app->user->can('/ca-ba-survey/indexapprove_presurvey'))
					array_push($arrItemsChild_p, ['label' => yii::t('app','Approval'), 'icon' => 'check-square-o', 'url' => ['/ca-ba-survey/indexapprove_presurvey']]);

			if(Yii::$app->user->can('/ca-ba-survey/indexoverview_presurvey'))
					array_push($arrItemsChild_p, ['label' => yii::t('app','Overview'), 'icon' => 'check-square-o', 'url' => ['/ca-ba-survey/indexoverview_presurvey']]);

			if(count($arrItemsChild_p)!= 0)	
			array_push($arrItemsChild_0, ['label' => 'Pre-Survey', 'icon' => 'file-archive-o', 'url' => ['#'], 'items' => $arrItemsChild_p]);
			
			if(Yii::$app->user->can('/ca-ba-survey/index'))
					array_push($arrItemsChild_a, ['label' => yii::t('app','Input'), 'icon' => 'plus', 'url' => ['/ca-ba-survey/index']]);

			if(Yii::$app->user->can('/ca-ba-survey/indexverify'))
					array_push($arrItemsChild_a, ['label' => yii::t('app','Verification'), 'icon' => 'eye', 'url' => ['/ca-ba-survey/indexverify']]);

			if(Yii::$app->user->can('/ca-ba-survey/indexapprove'))
					array_push($arrItemsChild_a, ['label' => yii::t('app','Approval'), 'icon' => 'check-square-o', 'url' => ['/ca-ba-survey/indexapprove']]);

			array_push($arrItemsChild_0, ['label' => 'BA Survey', 'icon' => 'file-archive-o', 'url' => ['#'], 'items' => $arrItemsChild_a]);

			if(Yii::$app->user->can('/ca-ba-survey/index_iom'))
					array_push($arrItemsChild_b, ['label' => yii::t('app','Input'), 'icon' => 'plus', 'url' => ['/ca-ba-survey/index_iom']]);

			if(Yii::$app->user->can('/ca-ba-survey/indexverify_iom'))
					array_push($arrItemsChild_b, ['label' => yii::t('app','Verification'), 'icon' => 'eye', 'url' => ['/ca-ba-survey/indexverify_iom']]);

			if(Yii::$app->user->can('/ca-ba-survey/indexapprove_iom'))
					array_push($arrItemsChild_b, ['label' => yii::t('app','Approval'), 'icon' => 'check-square-o', 'url' => ['/ca-ba-survey/indexapprove_iom']]);

			array_push($arrItemsChild_0, ['label' => 'Available to Roll Out', 'icon' => 'file-archive-o', 'url' => ['#'], 'items' => $arrItemsChild_b]);

			if(Yii::$app->user->can('/ca-ba-survey/indexoverview')){
				    array_push($arrItemsChild_0, ['label' => yii::t('app','BA Survey Overview'), 'icon' => 'search', 'url' => ['/ca-ba-survey/indexoverview']]);
					array_push($arrItemsChild_0, ['label' => yii::t('app','Log History'), 'icon' => 'search', 'url' => ['/ca-ba-survey/indexlog']]);
			}
					
			if(Yii::$app->user->can('/homepass/index'))
					array_push($arrItemsChild_0, ['label' => yii::t('app','Homepass Overview'), 'icon' => 'home', 'url' => ['/homepass/index']]);
					

			array_push($arrItems, ['label' => 'Manage Area', 'icon' => 'map-o', 'url' => ['#'], 'items' => $arrItemsChild_0]);
		}	
			
			
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
