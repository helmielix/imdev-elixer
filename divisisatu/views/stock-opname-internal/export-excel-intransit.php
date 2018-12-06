<?php
use divisisatu\models\MasterItemIm;

header("Content-Type:   application/vnd.ms-excel; charset=utf-8");

$models = MasterItemIm::find()
    ->where('status != :status', ['status' => 45])
    ->all();

forEach ($models as $model) {
    $model->s_good = 0;
    $model->s_not_good = 0;
    $model->s_dismantle_good = 0;
    $model->s_dismantle_not_good = 0;
    $model->s_reject = 0;
    $model->s_good_recondition = 0;
}

$intransit = MasterItemIm::find()
    ->where(['status' => 45])
    ->all();

\moonland\phpexcel\Excel::widget([
    'isMultipleSheet' => true,
    'models' => [
        'stock' => $models,
        'intransit' => $intransit,
    ],
    'fileName' => 'stock.xlsx',
    'columns' => [
        'stock' => ['orafin_code', 'im_code', 'name', 'brand', 'grouping', 's_good', 's_not_good', 's_reject', 's_dismantle_good', 's_dismantle_not_good', 's_good_recondition'],
        'intransit' => ['im_code', 'name', 'stock_qty', 'sn_type', 'brand', 'type']
    ],
    'headers' => [
        'stock' => ['s_good' => 'Good', 's_not_good' => 'Not Good', 's_reject' => 'Reject', 's_dismantle_good' => 'Dismantle Good', 's_dismantle_not_good' => 'Dismantle Not Good', 's_good_recondition' => 'Good Recondition'],
        'intransit' => ['sn_type' => 'SN/NO SN', 'type' => 'UoM']
    ],
	'mode' => 'export', //default value as 'export'
]); ?>
