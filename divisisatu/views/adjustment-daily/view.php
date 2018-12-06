<?php

use yii\widgets\DetailView;
use yii\helpers\Html;
use yii\helpers\Url;
?>

<div class="outbound-wh-transfer-view">

    <div class="row">
        <div class="col-sm-6">
            <?=
            DetailView::widget([
                'model' => $model,
                'options' => ['class' => 'small table table-striped table-bordered detail-view'],
                'attributes' => [
                    [
                        'attribute' => 'no_adj',
                    //'label' => 'Nama Barang',
                    /* 'value' => function($model){
                      return $model->name;
                      } */
                    /* 'value' => function($model) {
                      return ['STB', 'OTB'];
                      } */
                    ],
                    [
                        'attribute' => 'no_sj',
                    //'label' => 'IM Code',
                    /* 'value' => function($model){
                      return $model->im_code;
                      } */
                    ],
                    [
                        'attribute' => 'berita_acara',
                        'format' => 'html',
                        //'label' => 'Brand',
                        'value' => function($model) {
                            return Html::a($model->berita_acara, 'download?id=' . $model->id_adjustment, ['value' => Url::to(['adjustment-daily' . '/' . 'download?id=' . $model->id_adjustment])]);
                        }
                    /* 'value' => function($model) {
                      return ['STB', 'OTB'];
                      } */
                    ],
                    [
                        'attribute' => 'catatan',
                    //'label' => 'QTY Req',
                    //'value' => 'item.im_code',
                    /* 'value' => function($model) {
                      return ['STB', 'OTB'];
                      } */
                    ],
                ]
            ]);
            ?>

            <?php //$session = Yii::$app->session->set('id_adjustment',$model->id_adjustment); ?>

            <?php
//            print_r($model);
//            echo Yii::$app->controller->action->id;
            $url=explode("?",Yii::$app->request->referrer);
            $back=explode("/",$url[0]);
//           echo end($back);
            if ($model->status_listing == 1 && end($back) == 'indexadjust') {
                echo Html::a('Adjust', ['/adjustment-daily/indexadjust', 'id' => $model->id_adjustment, 'action' => 'adjust'], ['class' => 'btn btn-success']);
            }
            ?>

        </div>
    </div>
</div>