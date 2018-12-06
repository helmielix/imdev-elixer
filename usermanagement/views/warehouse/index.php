<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\SearchWarehouse */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Warehouses';
$this->params['breadcrumbs'][] = $this->title;
$this->registerJsFile('@commonpath/js/btn_modal.js',['depends' => [\yii\web\JqueryAsset::className()]]);
?>
<?php Modal::begin([
		'header'=>'<h3 id="modalHeader"></h3>',
		'id'=>'modal',
		'size'=>'modal-lg',
		 
	]); 

	echo '<div id="modalContent"> </div>';

	Modal::end();
?>
<div class="warehouse-index">
	<?php \yii\widgets\Pjax::begin(['id' => 'pjax',]); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
			[
                'class' => 'yii\grid\ActionColumn',
                'template'=>'{update}',
				 
            ],
            'id_warehouse',
            'warehouse_name',
			[
				'attribute'=>'id_region',
				'value'=>function($searchModel){
					if($searchModel->idRegion){
						return $searchModel->idRegion->name;
					}
					
				}
			]

        ],
    ]); ?>
	<?php \yii\widgets\Pjax::end(); ?>
</div>
<script>
	$('.viewButton').click(function(){
        $('#modal').modal('show')
            .find('#modalContent')
            .load($(this).attr('value'));
        $('#modalHeader').html('<h3> '+ $(this).attr('header') +'</h3>');
    });
</script>