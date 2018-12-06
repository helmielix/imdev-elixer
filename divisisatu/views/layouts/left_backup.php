<aside class="main-sidebar">
    <section class="sidebar">

        <?php
        $arrItems = [];
        if (Yii::$app->user->can('/dashboard-ca/index')) {
            array_push($arrItems, ['label' => 'Dashboard', 'icon' => 'home', 'url' => ['/dashboard-ca/index']]);
        }


        $arrItemsChild = [];
        $arrItemsGrandChild = [];
        $arrItemsParent = [];
        //test
        array_push($arrItemsGrandChild, ['label' => yii::t('app', 'Input test'), 'icon' => 'plus', 'url' => ['/instruction-disposal/index']]);

        array_push($arrItemsGrandChild, ['label' => yii::t('app', 'Approval test'), 'icon' => 'check-square-o', 'url' => ['/instruction-disposal/indexapprove']]);
        array_push($arrItemsChild, ['label' => 'Repaire', 'icon' => 'balance-scale', 'url' => ['#'], 'items' => $arrItemsGrandChild]);
        array_push($arrItemsParent, ['label' => 'Instruction', 'icon' => 'balance-scale', 'url' => ['#'], 'items' => $arrItemsChild]);
         array_push($arrItems, ['label' => 'Inventory Control ', 'icon' => 'balance-scale', 'url' => ['#'], 'items' => $arrItemsParent]);
//       echo "<pre>";  print_r($arrItemsParent);
        $arrItemsChild = [];
        $arrItemsGrandChild = [];
        $arrItemsParent = [];
        //Disposal Instruction
        array_push($arrItemsChild, ['label' => yii::t('app', 'Input'), 'icon' => 'plus', 'url' => ['/instruction-disposal/index']]);

        array_push($arrItemsChild, ['label' => yii::t('app', 'Approval'), 'icon' => 'check-square-o', 'url' => ['/instruction-disposal/indexapprove']]);


        array_push($arrItemsParent, ['label' => 'Disposal Instruction', 'icon' => 'balance-scale', 'url' => ['#'], 'items' => $arrItemsChild]);

        array_push($arrItemsChild, ['label' => yii::t('app', 'Disposal'), 'icon' => 'plus', 'url' => ['/instruction-disposal-im/index']]);
//                                print_r($arrItemsParent);
        //WH Transfer Instruction
        $arrItemsChild = [];

        array_push($arrItemsChild, ['label' => yii::t('app', 'Input'), 'icon' => 'plus', 'url' => ['/instruction-wh-transfer/index']]);
        array_push($arrItemsChild, ['label' => yii::t('app', 'Approve'), 'icon' => 'plus', 'url' => ['/instruction-wh-transfer/indexapprove']]);

        array_push($arrItemsParent, ['label' => 'Warehouse Transfer', 'icon' => 'balance-scale', 'url' => ['#'], 'items' => $arrItemsChild]);

        //Production Instruction
        $arrItemsChild = [];
        array_push($arrItemsChild, ['label' => yii::t('app', 'Input'), 'icon' => 'plus', 'url' => ['/instruction-production/index']]);
        array_push($arrItemsChild, ['label' => yii::t('app', 'Approve'), 'icon' => 'plus', 'url' => ['/instruction-production/indexapprove']]);
        array_push($arrItemsChild, ['label' => yii::t('app', 'Tag SN'), 'icon' => 'check-square-o', 'url' => ['/instruction-production/indextagsn']]);

        array_push($arrItemsParent, ['label' => 'Instruction Production', 'icon' => 'balance-scale', 'url' => ['#'], 'items' => $arrItemsChild]);

        //Repair Instruction
        $arrItemsChild = [];
        array_push($arrItemsChild, ['label' => yii::t('app', 'Input'), 'icon' => 'plus', 'url' => ['/instruction-repair/index']]);
        array_push($arrItemsChild, ['label' => yii::t('app', 'Approve'), 'icon' => 'plus', 'url' => ['/instruction-repair/indexapprove']]);

        array_push($arrItemsParent, ['label' => 'Instruction Repair', 'icon' => 'balance-scale', 'url' => ['#'], 'items' => $arrItemsChild]);


        array_push($arrItems, ['label' => 'Instruction ', 'icon' => 'balance-scale', 'url' => ['#'], 'items' => $arrItemsParent]);


        $arrItemsChild = [];
        $arrItemsParent = [];

        //Inbound PO
        array_push($arrItemsChild, ['label' => yii::t('app', 'Input'), 'icon' => 'plus', 'url' => ['/inbound-po/index']]);

        array_push($arrItemsChild, ['label' => yii::t('app', 'Approval'), 'icon' => 'check-square-o', 'url' => ['/inbound-po/indexapprove']]);

        array_push($arrItemsChild, ['label' => yii::t('app', 'Tag SN'), 'icon' => 'check-square-o', 'url' => ['/inbound-po/indextagsn']]);

        array_push($arrItemsChild, ['label' => yii::t('app', 'Log History'), 'icon' => 'list', 'url' => ['/inbound-po/indexlog']]);

        array_push($arrItemsParent, ['label' => 'Inbound PO', 'icon' => 'balance-scale', 'url' => ['#'], 'items' => $arrItemsChild]);

        //Inbound WH Trasnfer
        $arrItemsChild = [];
        array_push($arrItemsChild, ['label' => yii::t('app', 'Input'), 'icon' => 'plus', 'url' => ['/inbound-wh-transfer/index']]);
        array_push($arrItemsChild, ['label' => yii::t('app', 'Approve'), 'icon' => 'plus', 'url' => ['/inbound-wh-transfer/indexapprove']]);
        array_push($arrItemsChild, ['label' => yii::t('app', 'Tag SN'), 'icon' => 'check-square-o', 'url' => ['/inbound-wh-transfer/indextagsn']]);

        array_push($arrItemsParent, ['label' => 'Warehouse Transfer', 'icon' => 'balance-scale', 'url' => ['#'], 'items' => $arrItemsChild]);

        //Inbound Repair
        $arrItemsChild = [];
        array_push($arrItemsChild, ['label' => yii::t('app', 'Input'), 'icon' => 'plus', 'url' => ['/inbound-repair/index']]);
        array_push($arrItemsChild, ['label' => yii::t('app', 'Tag SN'), 'icon' => 'check-square-o', 'url' => ['/inbound-repair/tagsn']]);

        array_push($arrItemsParent, ['label' => 'Inbound Repair', 'icon' => 'balance-scale', 'url' => ['#'], 'items' => $arrItemsChild]);

        array_push($arrItems, ['label' => 'Inbound ', 'icon' => 'balance-scale', 'url' => ['#'], 'items' => $arrItemsParent]);


        $arrItemsChild = [];
        $arrItemsParent = [];

        ## OUTBOUND WH Transfer
        array_push($arrItemsChild, ['label' => yii::t('app', 'Tag SN'), 'icon' => 'plus', 'url' => ['/outbound-wh-transfer/index']]);
        array_push($arrItemsChild, ['label' => yii::t('app', 'Print SJ'), 'icon' => 'check-square-o', 'url' => ['/outbound-wh-transfer/indexprintsj']]);

        array_push($arrItemsParent, ['label' => 'Warehouse Transfer', 'icon' => 'balance-scale', 'url' => ['#'], 'items' => $arrItemsChild]);

        ## OUTBOUND Repair
        $arrItemsChild = [];
        array_push($arrItemsChild, ['label' => yii::t('app', 'Tag SN'), 'icon' => 'plus', 'url' => ['/outbound-repair/index']]);
        array_push($arrItemsChild, ['label' => yii::t('app', 'Print SJ'), 'icon' => 'check-square-o', 'url' => ['/outbound-repair/indexprintsj']]);
        array_push($arrItemsChild, ['label' => yii::t('app', 'Approval'), 'icon' => 'check-square-o', 'url' => ['/outbound-repair/indexapproval']]);

        array_push($arrItemsParent, ['label' => 'Repair Outbound', 'icon' => 'balance-scale', 'url' => ['#'], 'items' => $arrItemsChild]);

        array_push($arrItems, ['label' => 'Outbound ', 'icon' => 'balance-scale', 'url' => ['#'], 'items' => $arrItemsParent]);

        // Adjustment Daily
        $arrItemsChild = [];
        $arrItemsParent = [];
        array_push($arrItems, ['label' => 'Adjustment Daily', 'icon' => 'balance-scale', 'url' => ['/adjustment-daily/index'], 'items' => $arrItemsParent]);

        echo dmstr\widgets\Menu::widget(
                [
                    'options' => ['class' => 'sidebar-menu'],
                    'items' => $arrItems
                ]
        )
        ?>


    </section>
</aside>
