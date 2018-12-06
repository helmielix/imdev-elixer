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
        array_push($arrItemsChild, ['label' => yii::t('app', 'Master Item IM'), 'icon' => 'plus', 'url' => ['#']]);
        array_push($arrItemsChild, ['label' => yii::t('app', 'Reference'), 'icon' => 'check-square-o', 'url' => ['#']]);
        array_push($arrItemsParent, ['label' => 'Manage Item', 'icon' => 'balance-scale', 'url' => ['#'], 'items' => $arrItemsChild]);

        $arrItemsChild = [];
        $arrItemsGrandChild = [];
        $arrItemsParent = [];
        array_push($arrItemsChild, ['label' => yii::t('app', 'Warehouse'), 'icon' => 'check-square-o', 'url' => ['#']]);
        array_push($arrItemsParent, ['label' => 'Manage Warehouse', 'icon' => 'balance-scale', 'url' => ['#'], 'items' => $arrItemsChild]);

        $arrItemsChild = [];
        $arrItemsGrandChild = [];
        $arrItemsParent = [];

        //wh transfer
        array_push($arrItemsGrandChild, ['label' => yii::t('app', 'Input'), 'icon' => 'plus', 'url' => ['/instruction-wh-transfer/index']]);
        array_push($arrItemsGrandChild, ['label' => yii::t('app', 'Approval'), 'icon' => 'check-square-o', 'url' => ['/instruction-wh-transfer/indexapprove']]);
        array_push($arrItemsChild, ['label' => 'Warehouse Transfer', 'icon' => 'balance-scale', 'url' => ['#'], 'items' => $arrItemsGrandChild]);

        $arrItemsGrandChild = [];

        //repair
        array_push($arrItemsGrandChild, ['label' => yii::t('app', 'Input'), 'icon' => 'plus', 'url' => ['/instruction-repair/index']]);
        array_push($arrItemsGrandChild, ['label' => yii::t('app', 'Approval'), 'icon' => 'check-square-o', 'url' => ['/instruction-repair/indexapprove']]);
        array_push($arrItemsChild, ['label' => 'Repair', 'icon' => 'balance-scale', 'url' => ['#'], 'items' => $arrItemsGrandChild]);
        $arrItemsGrandChild = [];
        //disposal
        array_push($arrItemsGrandChild, ['label' => yii::t('app', 'Input'), 'icon' => 'plus', 'url' => ['/instruction-disposal/index']]);
        array_push($arrItemsGrandChild, ['label' => yii::t('app', 'Approval'), 'icon' => 'check-square-o', 'url' => ['/instruction-disposal/index']]);
        array_push($arrItemsChild, ['label' => 'Disposal', 'icon' => 'balance-scale', 'url' => ['#'], 'items' => $arrItemsGrandChild]);
        $arrItemsGrandChild = [];
        //produksi
        array_push($arrItemsGrandChild, ['label' => yii::t('app', 'Input'), 'icon' => 'plus', 'url' => ['#']]);
        array_push($arrItemsGrandChild, ['label' => yii::t('app', 'Approval'), 'icon' => 'check-square-o', 'url' => ['#']]);
        array_push($arrItemsChild, ['label' => 'Produksi', 'icon' => 'balance-scale', 'url' => ['#'], 'items' => $arrItemsGrandChild]);
        $arrItemsGrandChild = [];
        //recondition
        array_push($arrItemsGrandChild, ['label' => yii::t('app', 'Input'), 'icon' => 'plus', 'url' => ['#']]);
        array_push($arrItemsGrandChild, ['label' => yii::t('app', 'Approval'), 'icon' => 'check-square-o', 'url' => ['#']]);
        array_push($arrItemsChild, ['label' => 'Recondition', 'icon' => 'balance-scale', 'url' => ['#'], 'items' => $arrItemsGrandChild]);
        $arrItemsGrandChild = [];

        array_push($arrItemsParent, ['label' => 'Instruction', 'icon' => 'balance-scale', 'url' => ['#'], 'items' => $arrItemsChild]);
        $arrItemsChild = [];
        $arrItemsGrandChild = [];
//        $arrItemsParent = [];
        array_push($arrItemsChild, ['label' => 'Daily', 'icon' => 'balance-scale', 'url' => ['/adjustment-daily/indexadjust']]);
        array_push($arrItemsGrandChild, ['label' => yii::t('app', 'Input'), 'icon' => 'plus', 'url' => ['#']]);
        array_push($arrItemsGrandChild, ['label' => yii::t('app', 'Verification'), 'icon' => 'check-square-o', 'url' => ['#']]);
        array_push($arrItemsGrandChild, ['label' => yii::t('app', 'Saldo Updated'), 'icon' => 'check-square-o', 'url' => ['#']]);
        array_push($arrItemsChild, ['label' => 'Stock Opname Internal', 'icon' => 'balance-scale', 'url' => ['#'], 'items' => $arrItemsGrandChild]);
        $arrItemsGrandChild = [];
        array_push($arrItemsGrandChild, ['label' => yii::t('app', 'Verification'), 'icon' => 'check-square-o', 'url' => ['#']]);
        array_push($arrItemsGrandChild, ['label' => yii::t('app', 'Approval'), 'icon' => 'check-square-o', 'url' => ['#']]);
        array_push($arrItemsChild, ['label' => 'Kehilangan Barang', 'icon' => 'balance-scale', 'url' => ['#'], 'items' => $arrItemsGrandChild]);
        $arrItemsGrandChild = [];
        array_push($arrItemsGrandChild, ['label' => yii::t('app', 'Input'), 'icon' => 'plus', 'url' => ['#']]);
        array_push($arrItemsGrandChild, ['label' => yii::t('app', 'Verification'), 'icon' => 'check-square-o', 'url' => ['#']]);
        array_push($arrItemsGrandChild, ['label' => yii::t('app', 'Approval'), 'icon' => 'check-square-o', 'url' => ['#']]);
        array_push($arrItemsChild, ['label' => 'List GRF', 'icon' => 'balance-scale', 'url' => ['#'], 'items' => $arrItemsGrandChild]);
        array_push($arrItemsChild, ['label' => 'Overview All Warehouse', 'icon' => 'balance-scale', 'url' => ['#']]);

        array_push($arrItemsParent, ['label' => 'Adjustment', 'icon' => 'balance-scale', 'url' => ['#'], 'items' => $arrItemsChild]);

        array_push($arrItems, ['label' => 'Inventory Control ', 'icon' => 'balance-scale', 'url' => ['#'], 'items' => $arrItemsParent]);

        // root child reset
        $arrItemsChild = [];
        $arrItemsGrandChild = [];
        $arrItemsParent = [];

        array_push($arrItemsGrandChild, ['label' => yii::t('app', 'Input'), 'icon' => 'plus', 'url' => ['#']]);
        array_push($arrItemsGrandChild, ['label' => yii::t('app', 'Verification'), 'icon' => 'check-square-o', 'url' => ['#']]);
        array_push($arrItemsGrandChild, ['label' => yii::t('app', 'Approval'), 'icon' => 'check-square-o', 'url' => ['#']]);
        array_push($arrItemsGrandChild, ['label' => yii::t('app', 'Tag SN'), 'icon' => 'plus', 'url' => ['#']]);
        array_push($arrItemsChild, ['label' => 'Inbound PO', 'icon' => 'balance-scale', 'url' => ['#'], 'items' => $arrItemsGrandChild]);
        $arrItemsGrandGrandChild = [];
        $arrItemsGrandChild = [];
        array_push($arrItemsGrandGrandChild, ['label' => yii::t('app', 'Input'), 'icon' => 'plus', 'url' => ['#']]);
        array_push($arrItemsGrandGrandChild, ['label' => yii::t('app', 'Verification'), 'icon' => 'check-square-o', 'url' => ['#']]);
        array_push($arrItemsGrandGrandChild, ['label' => yii::t('app', 'Approval'), 'icon' => 'check-square-o', 'url' => ['#']]);
        array_push($arrItemsGrandChild, ['label' => yii::t('app', 'Barang Masuk'), 'icon' => 'plus', 'url' => ['#'], 'items' => $arrItemsGrandGrandChild]);
        $arrItemsGrandGrandChild = [];
        array_push($arrItemsGrandGrandChild, ['label' => yii::t('app', 'Input'), 'icon' => 'plus', 'url' => ['#']]);
        array_push($arrItemsGrandGrandChild, ['label' => yii::t('app', 'Approval'), 'icon' => 'check-square-o', 'url' => ['#']]);
        array_push($arrItemsGrandChild, ['label' => yii::t('app', 'Tag SN'), 'icon' => 'plus', 'url' => ['#'], 'items' => $arrItemsGrandGrandChild]);
        array_push($arrItemsChild, ['label' => 'Warehouse Transfer', 'icon' => 'balance-scale', 'url' => ['#'], 'items' => $arrItemsGrandChild]);

//        $arrItemsChild = [];
        $arrItemsGrandChild = [];

        array_push($arrItemsGrandChild, ['label' => yii::t('app', 'Input'), 'icon' => 'plus', 'url' => ['/inbound-repair/index']]);
        array_push($arrItemsGrandChild, ['label' => yii::t('app', 'Tag SN'), 'icon' => 'plus', 'url' => ['/inbound-repair/indexsn']]);
        array_push($arrItemsChild, ['label' => 'Repair', 'icon' => 'balance-scale', 'url' => ['#'], 'items' => $arrItemsGrandChild]);
        $arrItemsGrandChild = [];

        array_push($arrItemsGrandChild, ['label' => yii::t('app', 'Input'), 'icon' => 'plus', 'url' => ['#']]);
        array_push($arrItemsChild, ['label' => 'Produksi', 'icon' => 'balance-scale', 'url' => ['#'], 'items' => $arrItemsGrandChild]);
        $arrItemsGrandChild = [];

        array_push($arrItemsGrandChild, ['label' => yii::t('app', 'Tag SN'), 'icon' => 'plus', 'url' => ['#']]);
        array_push($arrItemsChild, ['label' => 'Peminjaman', 'icon' => 'balance-scale', 'url' => ['#'], 'items' => $arrItemsGrandChild]);
        $arrItemsGrandChild = [];

        array_push($arrItemsGrandChild, ['label' => yii::t('app', 'Tag SN'), 'icon' => 'plus', 'url' => ['#']]);
        array_push($arrItemsChild, ['label' => 'GRF', 'icon' => 'balance-scale', 'url' => ['#'], 'items' => $arrItemsGrandChild]);
        $arrItemsGrandChild = [];
        array_push($arrItemsGrandChild, ['label' => yii::t('app', 'Input'), 'icon' => 'plus', 'url' => ['#']]);
        array_push($arrItemsGrandChild, ['label' => yii::t('app', 'Tag SN'), 'icon' => 'plus', 'url' => ['#']]);
        array_push($arrItemsChild, ['label' => 'Dismantle', 'icon' => 'balance-scale', 'url' => ['#'], 'items' => $arrItemsGrandChild]);
        $arrItemsGrandChild = [];
        array_push($arrItemsGrandChild, ['label' => yii::t('app', 'Tag SN'), 'icon' => 'plus', 'url' => ['#']]);
        array_push($arrItemsChild, ['label' => 'Recondition', 'icon' => 'balance-scale', 'url' => ['#'], 'items' => $arrItemsGrandChild]);

        $arrItemsGrandChild = [];


        array_push($arrItemsParent, ['label' => 'Inbound', 'icon' => 'balance-scale', 'url' => ['#'], 'items' => $arrItemsChild]);

        $arrItemsChild = [];
        $arrItemsGrandChild = [];

        array_push($arrItemsGrandChild, ['label' => yii::t('app', 'Tag SN'), 'icon' => 'plus', 'url' => ['#']]);
        array_push($arrItemsGrandChild, ['label' => yii::t('app', 'Print SJ'), 'icon' => 'plus', 'url' => ['#']]);
        array_push($arrItemsGrandChild, ['label' => yii::t('app', 'Approve SJ'), 'icon' => 'check-square-o', 'url' => ['#']]);
        array_push($arrItemsChild, ['label' => 'Warehouse Transfer', 'icon' => 'balance-scale', 'url' => ['#'], 'items' => $arrItemsGrandChild]);
        $arrItemsGrandChild = [];
        array_push($arrItemsGrandChild, ['label' => yii::t('app', 'Tag SN'), 'icon' => 'plus', 'url' => ['/outbound-repair/index']]);
        array_push($arrItemsGrandChild, ['label' => yii::t('app', 'Print SJ'), 'icon' => 'plus', 'url' => ['/outbound-repair/indexprintsj']]);
        array_push($arrItemsGrandChild, ['label' => yii::t('app', 'Approve SJ'), 'icon' => 'check-square-o', 'url' => ['/outbound-repair/indexapproval']]);
        array_push($arrItemsChild, ['label' => 'Repair', 'icon' => 'balance-scale', 'url' => ['#'], 'items' => $arrItemsGrandChild]);
        $arrItemsGrandChild = [];
        array_push($arrItemsGrandChild, ['label' => yii::t('app', 'Tag SN'), 'icon' => 'plus', 'url' => ['#']]);
        array_push($arrItemsGrandChild, ['label' => yii::t('app', 'Print SJ'), 'icon' => 'plus', 'url' => ['#']]);
        array_push($arrItemsGrandChild, ['label' => yii::t('app', 'Approve SJ'), 'icon' => 'check-square-o', 'url' => ['#']]);
        array_push($arrItemsChild, ['label' => 'Disposal', 'icon' => 'balance-scale', 'url' => ['#'], 'items' => $arrItemsGrandChild]);
        $arrItemsGrandChild = [];
        array_push($arrItemsGrandChild, ['label' => yii::t('app', 'Tag SN'), 'icon' => 'plus', 'url' => ['#']]);
        array_push($arrItemsGrandChild, ['label' => yii::t('app', 'Print SJ'), 'icon' => 'plus', 'url' => ['#']]);
        array_push($arrItemsGrandChild, ['label' => yii::t('app', 'Approve SJ'), 'icon' => 'check-square-o', 'url' => ['#']]);
        array_push($arrItemsChild, ['label' => 'Produksi', 'icon' => 'balance-scale', 'url' => ['#'], 'items' => $arrItemsGrandChild]);
        $arrItemsGrandChild = [];
        array_push($arrItemsGrandChild, ['label' => yii::t('app', 'Tag SN'), 'icon' => 'plus', 'url' => ['#']]);
        array_push($arrItemsGrandChild, ['label' => yii::t('app', 'Print SJ'), 'icon' => 'plus', 'url' => ['#']]);
        array_push($arrItemsGrandChild, ['label' => yii::t('app', 'Approve SJ'), 'icon' => 'check-square-o', 'url' => ['#']]);
        array_push($arrItemsChild, ['label' => 'Peminjaman', 'icon' => 'balance-scale', 'url' => ['#'], 'items' => $arrItemsGrandChild]);
        $arrItemsGrandChild = [];
        array_push($arrItemsGrandChild, ['label' => yii::t('app', 'Tag SN'), 'icon' => 'plus', 'url' => ['#']]);
        array_push($arrItemsGrandChild, ['label' => yii::t('app', 'Print SJ'), 'icon' => 'plus', 'url' => ['#']]);
        array_push($arrItemsGrandChild, ['label' => yii::t('app', 'Approve SJ'), 'icon' => 'check-square-o', 'url' => ['#']]);
        array_push($arrItemsChild, ['label' => 'GRF', 'icon' => 'balance-scale', 'url' => ['#'], 'items' => $arrItemsGrandChild]);
        $arrItemsGrandChild = [];
        array_push($arrItemsGrandChild, ['label' => yii::t('app', 'Tag SN'), 'icon' => 'plus', 'url' => ['#']]);
        array_push($arrItemsGrandChild, ['label' => yii::t('app', 'Print SJ'), 'icon' => 'plus', 'url' => ['#']]);
        array_push($arrItemsGrandChild, ['label' => yii::t('app', 'Approve SJ'), 'icon' => 'check-square-o', 'url' => ['#']]);
        array_push($arrItemsChild, ['label' => 'Recondition', 'icon' => 'balance-scale', 'url' => ['#'], 'items' => $arrItemsGrandChild]);
// $arrItemsGrandChild = [];

        array_push($arrItemsParent, ['label' => 'Outbound', 'icon' => 'balance-scale', 'url' => ['#'], 'items' => $arrItemsChild]);
        array_push($arrItemsParent, ['label' => 'Adjustment Daily', 'icon' => 'balance-scale', 'url' => ['/adjustment-daily/index']]);
        $arrItemsChild = [];

        array_push($arrItems, ['label' => 'Warehouse ', 'icon' => 'balance-scale', 'url' => ['#'], 'items' => $arrItemsParent]);
         $arrItemsChild = [];
        $arrItemsGrandChild = [];
        $arrItemsParent = [];
         array_push($arrItemsParent, ['label' => yii::t('app', 'Verification'), 'icon' => 'check-square-o', 'url' => ['#']]);
        array_push($arrItemsParent, ['label' => yii::t('app', 'Approver'), 'icon' => 'check-square-o', 'url' => ['#']]);
        array_push($arrItemsParent, ['label' => yii::t('app', 'Saldo Updated'), 'icon' => 'check-square-o', 'url' => ['#']]);        
         array_push($arrItems, ['label' => 'Stock Opname By AM ', 'icon' => 'balance-scale', 'url' => ['#'], 'items' => $arrItemsParent]);
        $arrItemsParent = [];
         array_push($arrItemsParent, ['label' => yii::t('app', 'Hasil Stock Opname'), 'icon' => 'check-square-o', 'url' => ['#']]);
        array_push($arrItemsParent, ['label' => yii::t('app', 'Saldo Updated'), 'icon' => 'check-square-o', 'url' => ['#']]);        
         array_push($arrItems, ['label' => 'Stock Opname Internal ', 'icon' => 'balance-scale', 'url' => ['#'], 'items' => $arrItemsParent]);
         array_push($arrItems, ['label' => 'Master Stock ', 'icon' => 'balance-scale', 'url' => ['#']]);
         array_push($arrItems, ['label' => 'Report ', 'icon' => 'balance-scale', 'url' => ['#']]);
//        $arrItemsParent = [];
//        array_push($arrItems, ['label' => '', 'icon' => 'balance-scale', 'url' => [''], 'items' => $arrItemsParent]);

        echo dmstr\widgets\Menu::widget(
                [
                    'options' => ['class' => 'sidebar-menu'],
                    'items' => $arrItems
                ]
        )
        ?>


    </section>
</aside>
