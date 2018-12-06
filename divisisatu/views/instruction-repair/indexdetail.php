<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;

$this->registerJsFile('@commonpath/js/btn_modal.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJs(
// "$(document).on('ready pjax:success', function() {
        // // $('.modalButton').click(function(e){
        // // e.preventDefault(); //for prevent default behavior of <a> tag.
        // // var tagname = $(this)[0].tagName;
        // // $('#editModalId').modal('show').find('.modalContent').load($(this).attr('href'));
        // // });
        // console.log('ready pjax:success indexdetail');
        // $.pjax.reload({container:'#pjaxindexdetail',timeout: false});
        // });
        "
	// $(document).on('ready pjax:end', function(event) {
	  // $(event.target).initializeMyPlugin()
	// })
");
?>

<div class="instruction-wh-transfer-detail-index">

    <?php
    //echo 'hello!';
//    echo $this->context->action->id; ($this->context->action->id == 'view' && $model->status_listing==7)
        //($this->context->action->id == 'view'
        //if ($searchModel->status_listing != 1) {
        //var_dump($searchModel->idInstructionWh);
    //if ($this->context->action->id == 'indexdetail' || $this->context->action->id == 'deletedetail') {
    if ($this->context->action->id != 'viewapprove' && $model->status_listing != 2 && $this->context->action->id != 'view') {
    ?>

        <p>
            <?= Html::button(Yii::t('app', 'Add'), ['id' => 'createButton', 'class' => 'btn btn-success']) ?>
        </p>
    <?php } ?>
    <?php
    Pjax::begin([
        'id' => 'pjaxindexdetail',
        'timeout' => false,
        'enablePushState' => false,
        'clientOptions' => ['method' => 'GET', 'backdrop' => false,
            "container" => "#pjaxindexdetail"
        ],
    ]);
    ?>
    <?=
    GridView::widget([
        'id' => 'gridViewindexdetail',
        'dataProvider' => $dataProvider,
         'filterModel' => $searchModel,
        'floatHeader' => true,
        'floatOverflowContainer' => true,
        // 'summary' => "<span style='float: right; margin-right: 10px'> Showing {begin} - {end} of {totalCount} items </span>",
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}',
                'visibleButtons' => ['delete' => function($model) {
                        //if ($this->context->action->id == 'view' || $this->context->action->id=='viewapprove' || Yii::$app->controller->action->id == 'viewinstruction') {
                        if (Yii::$app->controller->action->id == 'viewapprove' ||  Yii::$app->controller->action->id == 'view') {
                            //echo $model->idInstructionWh->statusReference->status_listing;
                            return false;
                        } else {
                            return true;
                        }
                    }, 'update' => function($model) {
                        //if ($this->context->action->id == 'view' || $this->context->action->id=='viewapprove' || Yii::$app->controller->action->id == 'viewinstruction') {
                        if (Yii::$app->controller->action->id == 'viewapprove' || Yii::$app->controller->action->id == 'view') {
                            return false;
                        } else {
                            return true;
                        }
                    }
                ],
                'buttons' => [
                    'delete' => function ($url, $model) {
                        return Html::a('<span style="margin:0px 2px" class="glyphicon glyphicon-trash"></span>', '#', [
                                    'id' => 'trashButton', 'trash' => $model->id, 'title' => Yii::t('app', 'view'), 'class' => 'viewButton', /*'value' => Url::to([$this->context->id . '/deletedetail', 'id' => $model->id]),*/ 'header' => yii::t('app', 'Detail Repair Instructionr')
                        ]);
                    },
                    'update' => function ($url, $model) {
                        return Html::a('<span style="margin:0px 2px" class="glyphicon glyphicon-pencil"></span>', '#', [
                                    'title' => Yii::t('app', 'update'), 'class' => 'viewButton', 'value' => Url::to([$this->context->id . '/updatedetail', 'idDetail' => $model->id]), 'header' => yii::t('app', 'Detail Repair Instruction')
                        ]);
                    },
                ],
            ],
            [
                'attribute' => 'id_item_im',
                'value' => 'idMasterItemIm.im_code',
            ],
            [
                'attribute' => 'name',
                'value' => 'idMasterItemIm.name',
            ],
            [
                'attribute' => 'brand',
                'value' => 'idMasterItemIm.brand',
            ],
            [
                'attribute' => 'type',
                'value' => 'idMasterItemIm.type',
                'filter'=> yii\helpers\ArrayHelper::map(\common\models\MasterItemIm::find()->all(), 'type', 'type'),
            ],
            // [
            //     'attribute' => 'uom',
            //     'value' => 'idMasterItemIm.uom',
            // ],
            [
                'attribute' => 'warna',
                'value' => 'idMasterItemIm.warna',
            ],
            [
                'attribute' => 'sn_type',
                'value'=> function ($model) {
//                    print_r($model);
                        if ($model->idMasterItemIm->sn_type == 1) {
                            return 'SN';
                        } else {
                            return 'Non SN';
                        }
                    },
//                'value' => 'idMasterItemIm.sn_type',
                'filter'=>[1 => 'SN', 2 => "Non SN"],
            ],
            [
                'attribute' => 's_good',
                'value' => 'idMasterItemIm.s_good',
            ],
             [
                 'attribute' => 's_not_good',
                 'value' => 'idMasterItemIm.s_not_good',
             ],
            [
                'attribute' => 's_reject',
                'value' => 'idMasterItemIm.s_reject',
            ],
            'req_not_good',
            'req_reject',
            [
                'attribute' => 'rem_good',
                'value' => 'idMasterItemIm.s_good',
            ],
            // [
            //     'attribute' => 'rem_reject',
            //     'value' => 'idMasterItemIm.s_good',
            // ],
//            'rem_not_good',
                             [
                 'attribute' => 'rem_not_good',
                 'label' => 'Rem.Not Good',
                 'value' => function($model){
                        return $model->idMasterItemIm->s_good -@$model->req_not_good;
                 },
             ],
            'rem_reject',
        ],
    ]);
    ?>
    <?php yii\widgets\Pjax::end() /* Kalo misalnya drafted seperti ini untuk sementara waktu */ ?>
    <?php if ($this->context->action->id == 'indexdetail' /*||*/ /*$model->status_listing==7 || $model->status_listing==3*/) { ?>
        <p>        
            <?php
            //if (Yii::$app->controller->action->id == 'indexdetail')
                echo Html::button(Yii::t('app', 'Previous'), ['id' => 'previousButton', 'class' => 'btn btn-primary', 'style' => 'margin-top: 5px;']);
            ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <?= Html::button(Yii::t('app', 'Submit Instruction'), ['id' => 'submitButton', 'class' => 'btn btn-success', 'style' => 'margin-top: 5px;']) ?>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <?php
            //echo Yii::$app->controller->action->id;
            if($model->status_listing==7 && Yii::$app->controller->action->id!='indexdetail'){
                echo Html::button(Yii::t('app', 'Delete'), ['id' => 'deleteInsButton', 'class' => 'btn btn-danger', 'style' => 'margin-top: 5px;']);
            }
        ?>
        </p>
<?php }
//if(($this->context->action->id == 'view' && $model->status_listing==7) || ($this->context->action->id == 'view' && $model->status_listing==1)){
if (/*$model->status_listing==1 &&*/ Yii::$app->controller->action->id != 'viewapprove' && Yii::$app->controller->action->id != 'indexdetail') {
?>
       <p>
            <?= Html::button(Yii::t('app', 'Update'), ['id' => 'updateButton', 'class' => 'btn btn-success', 'style' => 'margin-top: 5px;']) ?>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <?php
            if($model->status_listing==7 || $model->status_listing==1){
                echo Html::button(Yii::t('app', 'Delete'), ['id' => 'deleteInsButton', 'class' => 'btn btn-danger', 'style' => 'margin-top: 5px;']);
            }
            ?>
        </p>  
        <?php
}
?>
</div>

<script>
    // $(document).on('ready pjax:end', function(event) {
    // $(event.target).initializeMyPlugin()
    // })
    $(document).on("pjax:send", function (e, contents) {
        var $contentBeforePut = $(contents);

        if (1 == 1) {
            console.log('success replace pjaxindexdetail ' + $contentBeforePut);
            // here I want to prevent put html content, I tried with:
            return false;
        }
    });

    $('#createButton').click(function () {
        $('#modal').modal('show')
            .find('#modalContent')
            .load('<?php
                $par = null;
                if (basename(Yii::$app->request->pathInfo) == 'view') {
                    $par = 'view';
                }
                echo Url::to([$this->context->id . '/createdetail', 'par' => $par]);
                ?>');
        $('#modalHeader').html('<h3> Create Detail Repair Instruction</h3>');
    });


    $('#previousButton').click(function () {
        $('#modal').modal('show')
                .find('#modalContent')
                .load('<?php echo Url::to([$this->context->id . '/update', 'id' => Yii::$app->session->get('idInstRep')]); ?>');
        $('#modalHeader').html('<h3>Update Repair Instruction </h3>');
    });

    $('#updateButton').click(function () {
        $('#modal').modal('show')
            .find('#modalContent')
            .load('<?php echo Url::to([$this->context->id . '/update', 'id' => $model->id]); ?>');
        $('#modalHeader').html('<h3> Update Repair Instruction</h3>');
    });

    $('#trashButton').click(function () {
        var resp = confirm("Do you want to delete this item???");

        if (resp == true) {
            var button = $(this);
            //alert(button.attr('trash'));
            //button.append(' <i id="spinRefresh" class="fa fa-spin fa-refresh"></i>');

            $.ajax({
                url: '<?php echo Url::to([$this->context->id . '/deletedetail'])?>' + '?id=' + button.attr('trash'),
                type: 'post',
                processData: false,
                contentType: false,
                success: function (response) {

                    $('#modal').modal('show')
                        .find('#modalContent')
                        .load('<?php echo Url::to([$this->context->id . '/indexdetail'])?>');
                    $('#modalHeader').html('<h3> Detail Repair Instruction </h3>');
                    //alert('success!');
                    /*if (response == 'success') {
                        $('#modal').modal('hide');
                    } else {
                        alert('error with message: ' + response.pesan);
                    }*/
                },
                error: function (xhr, getError) {
                    if (typeof getError === "object" && getError !== null) {
                        error = $.parseJSON(getError.responseText);
                        getError = error.message;
                    }
                    if (xhr.status != 302) {
                        alert("System recieve error with code: " + xhr.status);
                    }
                },
                complete: function () {
                    button.prop('disabled', false);
                    $('#spinRefresh').remove();
                },
            });
        }else {
            return false;
        }
    });

    $('#submitButton').click(function () {
        var button = $(this);
        button.prop('disabled', true);
        button.append(' <i id="spinRefresh" class="fa fa-spin fa-refresh"></i>');

        $.ajax({
            url: '<?php echo Url::to([$this->context->id . '/submit', 'id' => Yii::$app->session->get('idInstRep')]); ?>',
            type: 'post',
            processData: false,
            contentType: false,
            success: function (response) {
                if (response == 'success') {
                    $('#modal').modal('hide');
                } else {
                    alert('error with message: ' + response.pesan);
                }
            },
            error: function (xhr, getError) {
                if (typeof getError === "object" && getError !== null) {
                    error = $.parseJSON(getError.responseText);
                    getError = error.message;
                }
                if (xhr.status != 302) {
                    alert("System recieve error with code: " + xhr.status);
                }
            },
            complete: function () {
                button.prop('disabled', false);
                $('#spinRefresh').remove();
            },
        });
    });


    $('#deleteInsButton').click(function () {

        var resp = confirm("Do you want to delete this item???");
        if (resp == true) {
            var button = $(this);
            button.prop('disabled', true);
            button.append(' <i id="spinRefresh" class="fa fa-spin fa-refresh"></i>');

            $.ajax({
                url: '<?php echo Url::to([$this->context->id . '/delete', 'id' => Yii::$app->session->get('idInstRep')]); ?>',
                type: 'post',
                processData: false,
                contentType: false,
                success: function (response) {
                    if (response == 'success') {
                        $('#modal').modal('hide');
                    } else {
                        alert('error with message: ' + response.pesan);
                    }
                },
                error: function (xhr, getError) {
                    if (typeof getError === "object" && getError !== null) {
                        error = $.parseJSON(getError.responseText);
                        getError = error.message;
                    }
                    if (xhr.status != 302) {
                        alert("System recieve error with code: " + xhr.status);
                    }
                },
                complete: function () {
                    button.prop('disabled', false);
                    $('#spinRefresh').remove();
                },
            });
        }else {
            return false;
        }

    });
    $('.viewButton').click(function () {
        $('#modal').modal('show')
                .find('#modalContent')
                .load($(this).attr('value'));
        $('#modalHeader').html('<h3> ' + $(this).attr('header') + '</h3>');
    });

</script>
