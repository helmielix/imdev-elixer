<aside class="main-sidebar">
    <section class="sidebar">

		<?php $arrItems = [] ;
		if(Yii::$app->user->can('/dashboard-ca/index')) {
			array_push($arrItems,
				['label' => 'Dashboard', 'icon' => 'home', 'url' => ['/dashboard-ca/index']]);
		}


				$arrItemsChild = [];
				$arrItemsParent = [];
				//Disposal Instruction
				array_push($arrItemsChild, ['label' => yii::t('app','Input'), 'icon' => 'plus', 'url' => ['/instruction-disposal/index']]);

				array_push($arrItemsChild, ['label' => yii::t('app','Approval'), 'icon' => 'check-square-o', 'url' => ['/instruction-disposal/indexapprove']]);


				array_push($arrItemsParent, ['label' => 'Disposal Instruction', 'icon' => 'balance-scale', 'url' => ['#'], 'items' => $arrItemsChild]);

				array_push($arrItemsChild, ['label' => yii::t('app','Disposal'), 'icon' => 'plus', 'url' => ['/instruction-disposal-im/index']]);

				//WH Transfer Instruction
				$arrItemsChild = [];

				array_push($arrItemsChild, ['label' => yii::t('app','Input'), 'icon' => 'plus', 'url' => ['/instruction-wh-transfer/index']]);
				array_push($arrItemsChild, ['label' => yii::t('app','Approve'), 'icon' => 'plus', 'url' => ['/instruction-wh-transfer/indexapprove']]);

				array_push($arrItemsChild, ['label' => yii::t('app','Log History'), 'icon' => 'list', 'url' => ['/instruction-wh-transfer/indexlog']]);

				array_push($arrItemsParent, ['label' => 'Warehouse Transfer', 'icon' => 'balance-scale', 'url' => ['#'], 'items' => $arrItemsChild]);

				//Production Instruction
				$arrItemsChild = [];
				array_push($arrItemsChild, ['label' => yii::t('app','Input'), 'icon' => 'plus', 'url' => ['/instruction-production/index']]);
				array_push($arrItemsChild, ['label' => yii::t('app','Approve'), 'icon' => 'plus', 'url' => ['/instruction-production/indexapprove']]);
				array_push($arrItemsChild, ['label' => yii::t('app','Tag SN'), 'icon' => 'check-square-o', 'url' => ['/instruction-production/indextagsn']]);
				array_push($arrItemsChild, ['label' => yii::t('app','Log History'), 'icon' => 'list', 'url' => ['/instruction-production/indexlog']]);

				array_push($arrItemsParent, ['label' => 'Instruction Production', 'icon' => 'balance-scale', 'url' => ['#'], 'items' => $arrItemsChild]);

				//Repair Instruction
				$arrItemsChild = [];
				array_push($arrItemsChild, ['label' => yii::t('app','Input'), 'icon' => 'plus', 'url' => ['/instruction-repair/index']]);
				array_push($arrItemsChild, ['label' => yii::t('app','Approve'), 'icon' => 'plus', 'url' => ['/instruction-repair/indexapprove']]);
				array_push($arrItemsChild, ['label' => yii::t('app','Log History'), 'icon' => 'list', 'url' => ['/instruction-repair/indexlog']]);

				array_push($arrItemsParent, ['label' => 'Instruction Repair', 'icon' => 'balance-scale', 'url' => ['#'], 'items' => $arrItemsChild]);


				array_push($arrItems, ['label' => 'Instruction ', 'icon' => 'balance-scale', 'url' => ['#'], 'items' => $arrItemsParent]);

				## List Grf
				$arrItemsChild = [];
				$arrItemsParent = [];
				array_push($arrItemsParent, ['label' => yii::t('app','Input'), 'icon' => 'plus', 'url' => ['/instruction-grf/index']]);
				array_push($arrItemsParent, ['label' => yii::t('app','verify'), 'icon' => 'eye', 'url' => ['/instruction-grf/indexverify']]);
				array_push($arrItemsParent, ['label' => yii::t('app','Approve'), 'icon' => 'check-square-o', 'url' => ['/instruction-grf/indexapprove']]);

				array_push($arrItems, ['label' => 'List Grf', 'icon' => 'balance-scale', 'url' => ['#'], 'items' => $arrItemsParent]);

				$arrItemsChild = [];
				$arrItemsParent = [];
				array_push($arrItems, ['label' => yii::t('app','Asset Transfer'), 'icon' => 'balance-scale', 'url' => ['/instruction-grf/indexasset']]);
				// array_push($arrItemsParent, ['label' => yii::t('app','Approve'), 'icon' => 'check-square-o', 'url' => ['/inbound-grf/indexapprove']]);

				// array_push($arrItems, ['label' => 'List Grf', 'icon' => 'balance-scale', 'url' => ['#'], 'items' => $arrItemsParent]);

				## List Grf
				


				$arrItemsChild = [];
				$arrItemsParent = [];

				//Inbound PO
				array_push($arrItemsChild, ['label' => yii::t('app','Input'), 'icon' => 'plus', 'url' => ['/inbound-po/index']]);

				array_push($arrItemsChild, ['label' => yii::t('app','Verification'), 'icon' => 'check-square-o', 'url' => ['/inbound-po/indexverify']]);

				array_push($arrItemsChild, ['label' => yii::t('app','Approval'), 'icon' => 'check-square-o', 'url' => ['/inbound-po/indexapprove']]);

				array_push($arrItemsChild, ['label' => yii::t('app','Tag SN'), 'icon' => 'check-square-o', 'url' => ['/inbound-po/indextagsn']]);
				
				array_push($arrItemsChild, ['label' => yii::t('app','Log History'), 'icon' => 'list', 'url' => ['/inbound-po/indexlog']]);

				array_push($arrItemsParent, ['label' => 'Inbound PO', 'icon' => 'balance-scale', 'url' => ['#'], 'items' => $arrItemsChild]);

				//Inbound WH Trasnfer
				$arrItemsChild = [];
				$arrItemChildBrgMasuk = [];
				$arrItemChildTagSn= [];
				
				
				array_push($arrItemChildBrgMasuk, ['label' => yii::t('app','Input'), 'icon' => 'plus', 'url' => ['/inbound-wh-transfer/index']]);
				array_push($arrItemChildBrgMasuk, ['label' => yii::t('app','Verification'), 'icon' => 'plus', 'url' => ['/inbound-wh-transfer/indexverify']]);
				array_push($arrItemChildBrgMasuk, ['label' => yii::t('app','Approve'), 'icon' => 'plus', 'url' => ['/inbound-wh-transfer/indexapprove']]);
				array_push($arrItemsChild, ['label' => yii::t('app','Barang Masuk'), 'icon' => 'list', 'url' => ['#'], 'items' => $arrItemChildBrgMasuk]);
				
				array_push($arrItemChildTagSn, ['label' => yii::t('app','Input'), 'icon' => 'check-square-o', 'url' => ['/inbound-wh-transfer/indextagsn']]);
				array_push($arrItemChildTagSn, ['label' => yii::t('app','Approve'), 'icon' => 'check-square-o', 'url' => ['/inbound-wh-transfer/indextagsnapprove']]);
				array_push($arrItemsChild, ['label' => yii::t('app','Tag SN'), 'icon' => 'list', 'url' => ['#'], 'items' => $arrItemChildTagSn]);
				
				array_push($arrItemsChild, ['label' => yii::t('app','Log History'), 'icon' => 'list', 'url' => ['/inbound-wh-transfer/indexlog']]);

				array_push($arrItemsParent, ['label' => 'Warehouse Transfer', 'icon' => 'balance-scale', 'url' => ['#'], 'items' => $arrItemsChild]);

				//Inbound Grf
				$arrItemsChild = [];
				array_push($arrItemsChild, ['label' => yii::t('app','Tag SN'), 'icon' => 'plus', 'url' => ['/inbound-grf/index']]);
				
				array_push($arrItemsParent, ['label' => 'Peminjaman', 'icon' => 'balance-scale', 'url' => ['#'], 'items' => $arrItemsChild]);


				array_push($arrItems, ['label' => 'Inbound ', 'icon' => 'balance-scale', 'url' => ['#'], 'items' => $arrItemsParent]);


				$arrItemsChild = [];
				$arrItemsParent = [];

				## OUTBOUND WH Transfer
				array_push($arrItemsChild, ['label' => yii::t('app','Tag SN'), 'icon' => 'plus', 'url' => ['/outbound-wh-transfer/index']]);
				array_push($arrItemsChild, ['label' => yii::t('app','Print SJ'), 'icon' => 'check-square-o', 'url' => ['/outbound-wh-transfer/indexprintsj']]);
				array_push($arrItemsChild, ['label' => yii::t('app','Approval'), 'icon' => 'check-square-o', 'url' => ['/outbound-wh-transfer/indexapprove']]);

				array_push($arrItemsParent, ['label' => 'Warehouse Transfer', 'icon' => 'balance-scale', 'url' => ['#'], 'items' => $arrItemsChild]);

				## OUTBOUND Repair
				$arrItemsChild = [];
				array_push($arrItemsChild, ['label' => yii::t('app','Tag SN'), 'icon' => 'plus', 'url' => ['/outbound-repair/index']]);
				array_push($arrItemsChild, ['label' => yii::t('app','Print SJ'), 'icon' => 'check-square-o', 'url' => ['/outbound-repair/indexprintsj']]);

				array_push($arrItemsParent, ['label' => 'Repair Outbound', 'icon' => 'balance-scale', 'url' => ['#'], 'items' => $arrItemsChild]);

    			## OUTBOUND Grf
    			$arrItemsChild = [];
				array_push($arrItemsChild, ['label' => yii::t('app','Tag SN'), 'icon' => 'plus', 'url' => ['/outbound-grf/index']]);
				array_push($arrItemsChild, ['label' => yii::t('app','Print SJ'), 'icon' => 'check-square-o', 'url' => ['/outbound-grf/indexprintsj']]);
				array_push($arrItemsChild, ['label' => yii::t('app','Approve SJ'), 'icon' => 'check-square-o', 'url' => ['/outbound-grf/indexapprove']]);
				

				array_push($arrItemsParent, ['label' => 'Peminjaman', 'icon' => 'balance-scale', 'url' => ['#'], 'items' => $arrItemsChild]);

    			array_push($arrItems, ['label' => 'Outbound ', 'icon' => 'balance-scale', 'url' => ['#'], 'items' => $arrItemsParent]);

    			$arrItemsChild = [];
				array_push($arrItemsChild, ['label' => yii::t('app','Create Master Item Im'), 'icon' => 'fa fa-circle-oCreate', 'url' => ['/master-item-im/index']]);
				
				array_push($arrItemsChild, ['label' => yii::t('app','Manage WH'), 'icon' => 'fa fa-circle-oCreate', 'url' => ['/warehouse/index']]);

				array_push($arrItemsChild, ['label' => yii::t('app','Add Stock To Warehouse'), 'icon' => 'fa fa-circle-oCreate', 'url' => ['/master-item-im/indexitemwarehouse']]);

				array_push($arrItemsChild, ['label' => yii::t('app','Create Reference'), 'icon' => 'fa fa-circle-oCreate', 'url' => ['/reference/index']]);
					
				array_push($arrItems, ['label' => 'Setting Master Item Im', 'icon' => 'cog', 'url' => ['#'], 'items' => $arrItemsChild]);	


			echo dmstr\widgets\Menu::widget(
				[
					'options' => ['class' => 'sidebar-menu'],
					'items' => $arrItems
				]
			)
		?>


    </section>
</aside>
