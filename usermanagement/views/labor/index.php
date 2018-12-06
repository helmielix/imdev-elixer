<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
/* @var $this yii\web\View */
/* @var $searchModel app\models\SearchLabor */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Labors';
$this->params['breadcrumbs'][] = $this->title;

$this->registerJsFile('@commonpath/js/btn_modal.js',['depends' => [\yii\web\JqueryAsset::className()]]);
?>
<?php Modal::begin([
		'header'=>'<h3 id="modalHeader"></h3>',
		'id'=>'modal',
		'size'=>'modal-lg'
	]); 

	echo '<div id="modalContent"> </div>';

	Modal::end();
?>
<div class="labor-index">

	
	<p>
		<?php if (Yii::$app->controller->action->id == 'index') { ?>
			
			<?= Html::a('Upload', '#create?header=Upload_Labor', ['class' => 'btn btn-success headerButton', 'id' => 'createModal', 'value'=>Url::to(['labor/create']), 'header'=> yii::t('app','Upload Labor')])?>
			
			<?= Html::a(Yii::t('app','Download Template'), ['labor/downloadfile', 'id' => 'templateLabor'], ['id'=>'downloadButton','class' => 'btn btn-info headerButton', 'data-method' => 'post', 'title' => 'Template Excel Labor']) ?>
		<?php } ?>
	</p>

    
	<?php \yii\widgets\Pjax::begin(['id' => 'pjax',]); ?>   
	<?= GridView::widget([
			'dataProvider' => $dataProvider,
			'filterModel' => $searchModel,
			'columns' => [
				['class' => 'yii\grid\SerialColumn'],

				'nik',
				'name',
				'position',
				'division',

			],
		]); ?>
	<?php \yii\widgets\Pjax::end(); ?>
</div>
