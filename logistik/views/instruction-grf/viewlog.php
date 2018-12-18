<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use common\models\LaborForo;
use common\models\Labor;

/* @var $this yii\web\View */
/* @var $model divisisatu\models\InstructionWhTransfer */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Instruction Wh Transfers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="instruction-wh-transfer-view">    

	<div class="row">
        <div class="col-sm-6">
            <?= DetailView::widget([
                'model' => $model,
                'options' => ['class' => 'small table table-striped table-bordered detail-view'],
                'template' => '<tr><th{captionOptions}>{label}</th><td{contentOptions}>{value}</td></tr>',
                'attributes' => [
                    [
                        'attribute' =>'grf_number',
                        'value' => $model->idGrf->grf_number,
                    ],
                    [
                        'attribute' =>'wo_number',
                        'value' => $model->idGrf->wo_number,
                    ],

                    // [
                    //     'attribute' =>'file_attachment_1',
                    //     'value' => $model->idGrf->file_attachment_1,
                    // ],

                    [
                        'attribute'=>'file_attachment_1',
                        'format'=>'raw',
                        'value' => function($model){
                            if ($this->context->action->id == 'exportpdf'){
                                return basename($model->idGrf->file_attachment_1);
                            }else{
                                return Html::a(basename($model->idGrf->file_attachment_1), ['downloadfile','id' => $model->id], $options = ['target'=>'_blank', 'data' => [
                                        'method' => 'post',
                                        'params' => [
                                            'data' => 'file_attachment_1',
                                        ]
                                    ]]);
                            }
                        },
                    ], 
                    [
                        'attribute'=>'file_attachment_2',
                        'format'=>'raw',
                        'value' => function($model){
                            if ($this->context->action->id == 'exportpdf'){
                                return basename($model->idGrf->file_attachment_2);
                            }else{
                                return Html::a(basename($model->idGrf->file_attachment_2), ['downloadfile','id' => $model->id], $options = ['target'=>'_blank', 'data' => [
                                        'method' => 'post',
                                        'params' => [
                                            'data' => 'file_attachment_2',
                                        ]
                                    ]]);
                            }
                        },
                    ], 
                   [
                        'attribute'=>'file_attachment_3',
                        'format'=>'raw',
                        'value' => function($model){
                            if ($this->context->action->id == 'exportpdf'){
                                return basename($model->idGrf->file_attachment_3);
                            }else{
                                return Html::a(basename($model->idGrf->file_attachment_3), ['downloadfile','id' => $model->id], $options = ['target'=>'_blank', 'data' => [
                                        'method' => 'post',
                                        'params' => [
                                            'data' => 'file_attachment_3',
                                        ]
                                    ]]);
                            }
                        },
                    ], 
                    [
                        'attribute'=>'grf_type',
                        'value'=>$model->idGrf->grfType->description,
                    ],
                    [
                        'attribute'=>'id_division',
                        'value'=>function($model){
                            if($model->idGrf->idDivision)return $model->idGrf->idDivision->nama;
                        }
                    ],
                     
                    'revision_remark'


                ],
            ]) ?>
        </div>
        <div class="col-sm-6">
            <?= DetailView::widget([
                'model' => $model,
                'options' => ['class' => 'small table table-striped table-bordered detail-view'],
                'template' => '<tr><th{captionOptions}>{label}</th><td{contentOptions}>{value}</td></tr>',
                'attributes' => [   
                    [
                        'attribute'=>'requestor',
                        'value'=>$model->idGrf->requestorName->description,
                        
                    ],
                    [
                        'attribute'=>'id_region',
                        'value'=>$model->idGrf->idRegion->name,
                        
                    ],
                    [
                        'attribute'=>'team_leader',
                        'value'=> function($model){
                            // return $model->idGrf->team_leader;
                            $laborcek = Labor::find()->andWhere(['nik' => $model->idGrf->team_leader])->exists();
                            if (!$laborcek) {
                            	if (is_numeric($model->idGrf->team_leader)) {                            		
                                	return LaborForo::find()->andWhere(['nik' => $model->idGrf->team_leader])->one()->name;                                
                            	}
                            }else{
                                return Labor::find()->andWhere(['nik' => $model->idGrf->team_leader])->one()->nama;
                            }
                            // if($model->idGrf->teamLeader)return $model->idGrf->teamLeader->nama;
                        }            
                    ],
                    [
                        'attribute'=>'team_name',
                        'value'=> function($model){
                            if(($model->idGrf->teamName))return $model->idGrf->teamName->description;
                        }            
                    ],
                    [
                        'label'=>'GRF Inputted By',
                        'value'=> function($model){
                            if(($model->idGrf->createdBy))return $model->idGrf->createdBy->username;
                        }            
                    ],
                    [
                         'label'=>'GRF Verified By',
                        'value'=> function($model){
                            if(($model->idGrf->verifiedBy))return $model->idGrf->verifiedBy->username;
                        }            
                    ],
                    [
                         'label'=>'GRF Approved By',
                        'value'=> function($model){
                            if(($model->idGrf->approvedBy))return $model->idGrf->approvedBy->username;
                        }            
                    ],
                    [
                        'label'=>'Inputted By',
                        'value'=> function($model){
                            if(($model->createdBy))return $model->createdBy->username;
                        }            
                    ],
                    [
                        'attribute'=>'purpose',
                        'value'=>$model->idGrf->purpose,

                    ],
                    [
                        'attribute'=>'id_warehouse',
                        'value'=>$model->idWarehouse->nama_warehouse,

                    ],
                ],
            ]) ?>
        </div>
        <div class="col-sm-12">            
        </div>
    </div>
	
	<hr>
	
	<?= $this->render('indexdetail', [
		'model' => $model,
        'searchModel' => $searchModel,
        'dataProvider' => $dataProvider,
    ]) ?>
	
	<?php if($this->context->action->id != 'view'){ ?>
	<p> 
        <?php if((Yii::$app->controller->action->id == 'viewapprove' && $model->status_listing != 5))
            echo Html::button(Yii::t('app','Reject'), ['id'=>'rejectButton','class' => 'btn btn-danger']); ?>
        <?php if((Yii::$app->controller->action->id == 'viewapprove' && $model->status_listing != 5) || 
				(Yii::$app->controller->action->id == 'viewinstruction' && $model->status_listing == 5))
            echo Html::button(Yii::t('app','Revise'), ['id'=>'reviseButton','class' => 'btn btn-warning']); ?>
        <?php if(Yii::$app->controller->action->id == 'viewapprove' && $model->status_listing != 5)
            echo Html::button(Yii::t('app','Approve'), ['id'=>'approveButton','class' => 'btn btn-success']); ?>
		<?php if((Yii::$app->controller->action->id == 'viewinstruction' && $model->status_listing == 5))
            echo Html::button(Yii::t('app','Create'), ['id'=>'createoutButton','class' => 'btn btn-success']); ?>
		
    </p>
	<?php } ?>	
	
	<?php $form = ActiveForm::begin([
        'enableClientValidation' => true,
        'id' => 'submitForm',
        'layout' => 'horizontal',
        'options' => [
            'style' => 'display:none;'
        ],
        'fieldConfig' => [
                'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
                'horizontalCssClasses' => [
                    'label' => 'col-sm-1',
                    'offset' => 'col-sm-offset-1',
                    'wrapper' => 'col-sm-6',
                    'error' => '',
                    'hint' => '',
                ],
            ],
    ]); ?>
		<div class="form-group field-instructionwhtransfer-revision_remark">
			<label class="control-label col-sm-2" for="instructionwhtransfer-revision_remark">Revision Remark</label>
			<div class="col-sm-6">
			<?= Html::textArea('InstructionWhTransfer[revision_remark]','',['rows' => '5', 'class' => 'form-control', 'id' => 'instruction-wh-transfer-revision_remark']) ?>
			</div>
		</div>
        <br />
        <?= Html::button(\Yii::t('app','Submit Remark'), ['id'=>'revisionButton','class' => 'btn btn-primary']) ?>
    <?php ActiveForm::end(); ?>

</div>

<script>

</script>
