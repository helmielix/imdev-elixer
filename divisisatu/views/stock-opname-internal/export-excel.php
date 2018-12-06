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

\moonland\phpexcel\Excel::widget([
	'models' => $models,
    'fileName' => 'stock.xlsx',
    'columns' => ['orafin_code', 'im_code', 'name', 'brand', 'grouping', 's_good', 's_not_good', 's_reject', 's_dismantle_good', 's_dismantle_not_good', 's_good_recondition'],
    'headers' => ['s_good' => 'Good', 's_not_good' => 'Not Good', 's_reject' => 'Reject', 's_dismantle_good' => 'Dismantle Good', 's_dismantle_not_good' => 'Dismantle Not Good', 's_good_recondition' => 'Good Recondition'],
	'mode' => 'export', //default value as 'export'
]); ?>
