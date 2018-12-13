<aside class="main-sidebar">
    <section class="sidebar">

		<?php $arrItems = [] ;
		if(Yii::$app->user->can('/dashboard-logistik/index')) {
			array_push($arrItems,
				['label' => 'Incoming task', 'icon' => 'home', 'url' => ['/dashboard-logistik/index']]);
		}

			$arrItemsParent = [];
			$arrItemsChild = [];
			$arrItemsChildChild = [];
			if(Yii::$app->user->can('/instruction-disposal/index') || Yii::$app->user->can('/instruction-disposal/indexapprove')) 
			{
				$arrItemsChild = [];
				$arrItemsChildChild = [];
				//Disposal Instruction
				if (Yii::$app->user->can('/instruction-disposal/index'))
					array_push($arrItemsChildChild, ['label' => yii::t('app','Input'), 'icon' => 'plus', 'url' => ['/instruction-disposal/index']]);

				if (Yii::$app->user->can('/instruction-disposal/indexapprove'))
					array_push($arrItemsChildChild, ['label' => yii::t('app','Approval'), 'icon' => 'check-square-o', 'url' => ['/instruction-disposal/indexapprove']]);


				array_push($arrItemsChild, ['label' => 'Disposal Instruction', 'icon' => 'balance-scale', 'url' => ['#'], 'items' => $arrItemsChildChild]);

			}

				// array_push($arrItemsChild, ['label' => yii::t('app','Disposal'), 'icon' => 'plus', 'url' => ['/instruction-disposal-im/index']]);

				//WH Transfer Instruction
			if(Yii::$app->user->can('/instruction-wh-transfer/index') || Yii::$app->user->can('/instruction-wh-transfer/indexapprove') || Yii::$app->user->can('/instruction-wh-transfer/indexoverview') || Yii::$app->user->can('/instruction-wh-transfer/indexlog')) {
				$arrItemsChildChild = [];

				if(Yii::$app->user->can('/instruction-wh-transfer/index'))
					array_push($arrItemsChildChild, ['label' => yii::t('app','Input'), 'icon' => 'plus', 'url' => ['/instruction-wh-transfer/index']]);
				if(Yii::$app->user->can('/instruction-wh-transfer/indexapprove'))
					array_push($arrItemsChildChild, ['label' => yii::t('app','Approve'), 'icon' => 'plus', 'url' => ['/instruction-wh-transfer/indexapprove']]);
				if(Yii::$app->user->can('/instruction-wh-transfer/indexoverview'))
					array_push($arrItemsChildChild, ['label' => yii::t('app','Overview'), 'icon' => 'list', 'url' => ['/instruction-wh-transfer/indexoverview']]);
				if(Yii::$app->user->can('/instruction-wh-transfer/indexlog'))
					array_push($arrItemsChildChild, ['label' => yii::t('app','Log History'), 'icon' => 'list', 'url' => ['/instruction-wh-transfer/indexlog']]);

				array_push($arrItemsChild, ['label' => 'Warehouse Transfer', 'icon' => 'balance-scale', 'url' => ['#'], 'items' => $arrItemsChildChild]);

			}

				//Production Instruction
			if(Yii::$app->user->can('/instruction-production/index') || Yii::$app->user->can('/instruction-production/indexapprove') || Yii::$app->user->can('/instruction-production/indextagsn') || Yii::$app->user->can('/instruction-production/indexlog')) {

				$arrItemsChildChild = [];

				if(Yii::$app->user->can('/instruction-production/index'))
					array_push($arrItemsChildChild, ['label' => yii::t('app','Input'), 'icon' => 'plus', 'url' => ['/instruction-production/index']]);
				if(Yii::$app->user->can('/instruction-production/indexapprove'))
					array_push($arrItemsChildChild, ['label' => yii::t('app','Approve'), 'icon' => 'plus', 'url' => ['/instruction-production/indexapprove']]);
				if(Yii::$app->user->can('/instruction-production/indexapprove'))
					array_push($arrItemsChildChild, ['label' => yii::t('app','Input Declare'), 'icon' => 'plus', 'url' => ['/instruction-production/indexdeclare']]);
				if(Yii::$app->user->can('/instruction-production/indexapprove'))
					array_push($arrItemsChildChild, ['label' => yii::t('app','Approve Declare'), 'icon' => 'plus', 'url' => ['/instruction-production/indexapprovedeclare']]);
				if(Yii::$app->user->can('/instruction-production/indextagsn'))
					array_push($arrItemsChildChild, ['label' => yii::t('app','Tag SN'), 'icon' => 'check-square-o', 'url' => ['/instruction-production/indextagsn']]);
				if(Yii::$app->user->can('/instruction-production/indexlog'))
					array_push($arrItemsChildChild, ['label' => yii::t('app','Log History'), 'icon' => 'list', 'url' => ['/instruction-production/indexlog']]);

				array_push($arrItemsChild, ['label' => 'Instruction Production', 'icon' => 'balance-scale', 'url' => ['#'], 'items' => $arrItemsChildChild]);
			}


				//Repair Instruction
			if(Yii::$app->user->can('/instruction-repair/index') || Yii::$app->user->can('/instruction-repair/indexapprove') || Yii::$app->user->can('/instruction-repair/indexlog')) 
			{
				$arrItemsChildChild = [];

				if(Yii::$app->user->can('/instruction-repair/index'))
					array_push($arrItemsChildChild, ['label' => yii::t('app','Input'), 'icon' => 'plus', 'url' => ['/instruction-repair/index']]);
				if(Yii::$app->user->can('/instruction-repair/indexapprove'))
					array_push($arrItemsChildChild, ['label' => yii::t('app','Approve'), 'icon' => 'plus', 'url' => ['/instruction-repair/indexapprove']]);
				if(Yii::$app->user->can('/instruction-repair/indexlog'))
					array_push($arrItemsChildChild, ['label' => yii::t('app','Log History'), 'icon' => 'list', 'url' => ['/instruction-repair/indexlog']]);

				array_push($arrItemsChild, ['label' => 'Instruction Repair', 'icon' => 'balance-scale', 'url' => ['#'], 'items' => $arrItemsChildChild]);
			}

			if(count($arrItemsChild ) >=1 ){
				array_push($arrItemsParent, ['label' => 'Instruction ', 'icon' => 'balance-scale', 'url' => ['#'], 'items' => $arrItemsChild]);
			}

//======================================================================================================================
			if(Yii::$app->user->can('#')) {
				$arrItemsChild = [];
				if(Yii::$app->user->can('#'))
					array_push($arrItemsParent, ['label' => 'Adjustment ', 'icon' => 'balance-scale', 'url' => ['#'], 'items' => $arrItemsChild]);
			}

//======================================================================================================================	
				## List Grf
			if(Yii::$app->user->can('/instruction-grf/index') || Yii::$app->user->can('/instruction-grf/indexapprove') || Yii::$app->user->can('/instruction-grf/indexverify')) {
				$arrItemsChild = [];
				if(Yii::$app->user->can('/instruction-grf/index'))
					array_push($arrItemsChild, ['label' => yii::t('app','Input'), 'icon' => 'plus', 'url' => ['/instruction-grf/index']]);
				if(Yii::$app->user->can('/instruction-grf/indexverify'))
					array_push($arrItemsChild, ['label' => yii::t('app','verify'), 'icon' => 'eye', 'url' => ['/instruction-grf/indexverify']]);
				if(Yii::$app->user->can('/instruction-grf/indexapprove'))
					array_push($arrItemsChild, ['label' => yii::t('app','Approve'), 'icon' => 'check-square-o', 'url' => ['/instruction-grf/indexapprove']]);

				array_push($arrItemsParent, ['label' => 'List Grf', 'icon' => 'balance-scale', 'url' => ['#'], 'items' => $arrItemsChild]);

			}
//======================================================================================================================			
				

				if(count($arrItemsChild) >=1 ){
				array_push($arrItems, ['label' => 'Inventory Control ', 'icon' => 'balance-scale', 'url' => ['#'], 'items' => $arrItemsParent]);
			}
//======================================================================================================================
				$arrItemsChild = [];
				$arrItemsParent = [];
				$arrItemsChildChild = [];


				//Inbound PO
			if(Yii::$app->user->can('/inbound-po/index') || Yii::$app->user->can('/inbound-po/indexverify')|| Yii::$app->user->can('/inbound-po/indexapprove') || Yii::$app->user->can('/inbound-po/indextagsn') || Yii::$app->user->can('/inbound-po/indexlog') || Yii::$app->user->can('/inbound-po/indexoverview')) 
			{
				$arrItemsChildChild = [];
				if(Yii::$app->user->can('/inbound-po/index'))
					array_push($arrItemsChildChild, ['label' => yii::t('app','Input'), 'icon' => 'plus', 'url' => ['/inbound-po/index']]);
				if(Yii::$app->user->can('/inbound-po/indexverify'))
					array_push($arrItemsChildChild, ['label' => yii::t('app','Verification'), 'icon' => 'check-square-o', 'url' => ['/inbound-po/indexverify']]);
				if(Yii::$app->user->can('/inbound-po/indexapprove'))
					array_push($arrItemsChildChild, ['label' => yii::t('app','Approval'), 'icon' => 'check-square-o', 'url' => ['/inbound-po/indexapprove']]);
				if(Yii::$app->user->can('/inbound-po/indextagsn'))
					array_push($arrItemsChildChild, ['label' => yii::t('app','Tag SN'), 'icon' => 'check-square-o', 'url' => ['/inbound-po/indextagsn']]);
				if(Yii::$app->user->can('/inbound-po/indexoverview'))
					array_push($arrItemsChildChild, ['label' => yii::t('app','Overview'), 'icon' => 'list', 'url' => ['/inbound-po/indexoverview']]);
				if(Yii::$app->user->can('/inbound-po/indexlog'))
					array_push($arrItemsChildChild, ['label' => yii::t('app','Log History'), 'icon' => 'list', 'url' => ['/inbound-po/indexlog']]);

				array_push($arrItemsChild, ['label' => 'Inbound PO', 'icon' => 'balance-scale', 'url' => ['#'], 'items' => $arrItemsChildChild]);
			}

				//Inbound WH Trasnfer
				$arrItemsChildChild = [];
				$arrItemChildBrgMasuk = [];
				$arrItemChildTagSn= [];
				
				if(Yii::$app->user->can('/inbound-wh-transfer/index') || Yii::$app->user->can('/inbound-wh-transfer/indexverify')|| Yii::$app->user->can('/inbound-wh-transfer/indexapprove') || Yii::$app->user->can('/inbound-wh-transfer/indextagsn')| Yii::$app->user->can('/inbound-wh-transfer/indexlog')) {

				$arrItemsChildChild = [];
				if(Yii::$app->user->can('/inbound-wh-transfer/index'))
					array_push($arrItemChildBrgMasuk, ['label' => yii::t('app','Input'), 'icon' => 'plus', 'url' => ['/inbound-wh-transfer/index']]);
				if(Yii::$app->user->can('/inbound-wh-transfer/indexverify'))
					array_push($arrItemChildBrgMasuk, ['label' => yii::t('app','Verification'), 'icon' => 'plus', 'url' => ['/inbound-wh-transfer/indexverify']]);
				if(Yii::$app->user->can('/inbound-wh-transfer/indexapprove'))
					array_push($arrItemChildBrgMasuk, ['label' => yii::t('app','Approve'), 'icon' => 'plus', 'url' => ['/inbound-wh-transfer/indexapprove']]);

					array_push($arrItemsChildChild, ['label' => yii::t('app','Barang Masuk'), 'icon' => 'list', 'url' => ['#'], 'items' => $arrItemChildBrgMasuk]);

			}

			if(Yii::$app->user->can('/inbound-wh-transfer/indextagsn') || Yii::$app->user->can('/inbound-wh-transfer/indextagsnapprove')) 
			{

				if(Yii::$app->user->can('/inbound-wh-transfer/indextagsn'))
					array_push($arrItemChildTagSn, ['label' => yii::t('app','Input'), 'icon' => 'check-square-o', 'url' => ['/inbound-wh-transfer/indextagsn']]);
				if(Yii::$app->user->can('/inbound-wh-transfer/indextagsnapprove'))
					array_push($arrItemChildTagSn, ['label' => yii::t('app','Approve'), 'icon' => 'check-square-o', 'url' => ['/inbound-wh-transfer/indextagsnapprove']]);

					array_push($arrItemsChildChild, ['label' => yii::t('app','Tag SN'), 'icon' => 'list', 'url' => ['#'], 'items' => $arrItemChildTagSn]);
			}
			if(Yii::$app->user->can('/inbound-wh-transfer/indexlog')) 
			{
				if(Yii::$app->user->can('/inbound-wh-transfer/indexlog'))
				array_push($arrItemsChildChild, ['label' => yii::t('app','Log History'), 'icon' => 'list', 'url' => ['/inbound-wh-transfer/indexlog']]);
			}


				if(count($arrItemsChildChild) >=1)
				{
					array_push($arrItemsChild, ['label' => 'Warehouse Transfer', 'icon' => 'balance-scale', 'url' => ['#'], 'items' => $arrItemsChildChild]);
				}


				//Inbound Grf PEMINJAMAN
				if(Yii::$app->user->can('/inbound-grf/index')) 
				{
				$arrItemsChildChild = [];
					if(Yii::$app->user->can('/inbound-wh-transfer/index'))
						array_push($arrItemsChildChild, ['label' => yii::t('app','Tag SN'), 'icon' => 'plus', 'url' => ['/inbound-grf/index']]);
				
				array_push($arrItemsChild, ['label' => 'Peminjaman', 'icon' => 'balance-scale', 'url' => ['#'], 'items' => $arrItemsChildChild]);
				}

			if(count($arrItemsChild) >=1 ){
				array_push($arrItemsParent, ['label' => 'Inbound ', 'icon' => 'balance-scale', 'url' => ['#'], 'items' => $arrItemsChild]);
			}
	//======================================================================================================================
				$arrItemsChild = [];
				$arrItemsChildChild = [];
				// $arrItemsParent = [];

				## OUTBOUND WH Transfer
				if(Yii::$app->user->can('/outbound-wh-transfer/index') || Yii::$app->user->can('/outbound-wh-transfer/indexprintsj') || Yii::$app->user->can('/outbound-wh-transfer/indexapprove')) 
			{
				if(Yii::$app->user->can('/outbound-wh-transfer/index'))
					array_push($arrItemsChildChild, ['label' => yii::t('app','Tag SN'), 'icon' => 'plus', 'url' => ['/outbound-wh-transfer/index']]);
				if(Yii::$app->user->can('/outbound-wh-transfer/indexprintsj'))
					array_push($arrItemsChildChild, ['label' => yii::t('app','Print SJ'), 'icon' => 'check-square-o', 'url' => ['/outbound-wh-transfer/indexprintsj']]);
				if(Yii::$app->user->can('/outbound-wh-transfer/indexapprove'))	
					array_push($arrItemsChildChild, ['label' => yii::t('app','Approval'), 'icon' => 'check-square-o', 'url' => ['/outbound-wh-transfer/indexapprove']]);

				array_push($arrItemsChild, ['label' => 'Warehouse Transfer', 'icon' => 'balance-scale', 'url' => ['#'], 'items' => $arrItemsChildChild]);

			}

				## OUTBOUND Repair
			if(Yii::$app->user->can('/outbound-repair/index') || Yii::$app->user->can('/outbound-repair/indexprintsj')) 
			{
				$arrItemsChildChild = [];
				if(Yii::$app->user->can('/outbound-repair/index'))
					array_push($arrItemsChildChild, ['label' => yii::t('app','Tag SN'), 'icon' => 'plus', 'url' => ['/outbound-repair/index']]);
				if(Yii::$app->user->can('/outbound-repair/indexprintsj'))
					array_push($arrItemsChildChild, ['label' => yii::t('app','Print SJ'), 'icon' => 'check-square-o', 'url' => ['/outbound-repair/indexprintsj']]);

				array_push($arrItemsChild, ['label' => 'Repair Outbound', 'icon' => 'balance-scale', 'url' => ['#'], 'items' => $arrItemsChildChild]);
			}
			// if(Yii::$app->user->can('/outbound-production/index') || Yii::$app->user->can('/outbound-production/indexprintsj') || Yii::$app->user->can('/outbound-production/indexapprove') || Yii::$app->user->can('/outbound-production/indeoveriew') || Yii::$app->user->can('/outbound-production/indexlog')) 
			// {
				$arrItemsChildChild = [];
				// ## OUTBOUND Produksi
				array_push($arrItemsChildChild, ['label' => yii::t('app','Tag SN'), 'icon' => 'plus', 'url' => ['/outbound-production/index']]);
				array_push($arrItemsChildChild, ['label' => yii::t('app','Print SJ'), 'icon' => 'check-square-o', 'url' => ['/outbound-production/indexprintsj']]);
				array_push($arrItemsChildChild, ['label' => yii::t('app','Approval'), 'icon' => 'check-square-o', 'url' => ['/outbound-production/indexapprove']]);
				array_push($arrItemsChildChild, ['label' => yii::t('app','Overview'), 'icon' => 'check-square-o', 'url' => ['/outbound-production/indeoveriew']]);
				array_push($arrItemsChildChild, ['label' => yii::t('app','Log History'), 'icon' => 'check-square-o', 'url' => ['/outbound-production/indexlog']]);

				array_push($arrItemsChild, ['label' => 'Produksi', 'icon' => 'balance-scale', 'url' => ['#'], 'items' => $arrItemsChildChild]);
			// }
    			## OUTBOUND Grf
			if(Yii::$app->user->can('/outbound-grf/index') || Yii::$app->user->can('/outbound-grf/indexprintsj')|| Yii::$app->user->can('/outbound-grf/indexapprove')) 
			{
    			$arrItemsChildChild = [];
    			if(Yii::$app->user->can('/outbound-grf/index'))
					array_push($arrItemsChildChild, ['label' => yii::t('app','Tag SN'), 'icon' => 'plus', 'url' => ['/outbound-grf/index']]);
				if(Yii::$app->user->can('/outbound-grf/indexprintsj'))
					array_push($arrItemsChildChild, ['label' => yii::t('app','Print SJ'), 'icon' => 'check-square-o', 'url' => ['/outbound-grf/indexprintsj']]);
				if(Yii::$app->user->can('/outbound-grf/indexapprove'))
					array_push($arrItemsChildChild, ['label' => yii::t('app','Approve SJ'), 'icon' => 'check-square-o', 'url' => ['/outbound-grf/indexapprove']]);
				

				array_push($arrItemsChild, ['label' => 'Peminjaman', 'icon' => 'balance-scale', 'url' => ['#'], 'items' => $arrItemsChildChild]);
			}

			if(count($arrItemsChild) >= 1)
			{
    			array_push($arrItemsParent, ['label' => 'Outbound ', 'icon' => 'balance-scale', 'url' => ['#'], 'items' => $arrItemsChild]);
    		}

	//======================================================================================================================
    		if(count($arrItemsParent) >= 1)
			{
				array_push($arrItems, ['label' => 'Warehouse', 'icon' => 'balance-scale', 'url' => ['#'], 'items' => $arrItemsParent]);
			}

				

			if(Yii::$app->user->can('/instruction-grf/indexasset')) 
			{
				$arrItemsChild = [];
				$arrItemsParent = [];
				if(Yii::$app->user->can('/instruction-grf/indexasset')) 
					array_push($arrItems, ['label' => yii::t('app','Asset Transfer'), 'icon' => 'balance-scale', 'url' => ['/instruction-grf/indexasset']]);
			}
				// array_push($arrItemsParent, ['label' => yii::t('app','Approve'), 'icon' => 'check-square-o', 'url' => ['/inbound-grf/indexapprove']]);

				// array_push($arrItems, ['label' => 'List Grf', 'icon' => 'balance-scale', 'url' => ['#'], 'items' => $arrItemsParent]);

				## List Grf
				


				


				
			if(Yii::$app->user->can('/master-item-im/index') || Yii::$app->user->can('/warehouse/index') || Yii::$app->user->can('/master-item-im/indexitemwarehouse') || Yii::$app->user->can('/reference/index') || Yii::$app->user->can('/parameter-master-item/index')) 
			{
    			$arrItemsChild = [];
    			if(Yii::$app->user->can('/master-item-im/index'))
					array_push($arrItemsChild, ['label' => yii::t('app','Create Master Item Im'), 'icon' => 'fa fa-circle-oCreate', 'url' => ['/master-item-im/index']]);
				if(Yii::$app->user->can('/warehouse/index'))
					array_push($arrItemsChild, ['label' => yii::t('app','Manage WH'), 'icon' => 'fa fa-circle-oCreate', 'url' => ['/warehouse/index']]);
				if(Yii::$app->user->can('/master-item-im/indexitemwarehouse'))
					array_push($arrItemsChild, ['label' => yii::t('app','Add Stock To Warehouse'), 'icon' => 'fa fa-circle-oCreate', 'url' => ['/master-item-im/indexitemwarehouse']]);
				if(Yii::$app->user->can('/reference/index'))
					array_push($arrItemsChild, ['label' => yii::t('app','Create Reference'), 'icon' => 'fa fa-circle-oCreate', 'url' => ['/reference/index']]);
				if(Yii::$app->user->can('/parameter-master-item/index'))
					array_push($arrItemsChild, ['label' => yii::t('app','Parameterize'), 'icon' => 'fa fa-circle-oCreate', 'url' => ['/parameter-master-item/index']]);
					
				array_push($arrItems, ['label' => 'Setting Master Item Im', 'icon' => 'cog', 'url' => ['#'], 'items' => $arrItemsChild]);	
			}


			echo dmstr\widgets\Menu::widget(
				[
					'options' => ['class' => 'sidebar-menu'],
					'items' => $arrItems
				]
			)
		?>


    </section>
</aside>
