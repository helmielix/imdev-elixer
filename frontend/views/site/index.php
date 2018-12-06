<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;



$this->title = 'Login';
$this->registerCssFile('@web/css/home.css',['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@web/js/home.js',['depends' => [\yii\web\JqueryAsset::className()]]);
?>

  <img src="<?php echo Url::base(); ?>/images/background_login.jpg" width="100%" height="100%" style='position:absolute; top: 0px; left: 0px; z-index:-100' />
  <?= Html::img('@commonpath/images/logo_mnc_play_small.png',$options=['class'=>'homeLogo']) ?>
	<?= Html::a('Logistik<span class="homeButtonDesc"> Logistik </span>', Url::base().'/../../logistik/web/', ['class'=>'homeButtonContainer']); ?>
		
	<?= Html::a('GRF<span class="homeButtonDesc"> Logistik</span>', Url::base().'/../../grflost/web/', ['class'=>'homeButtonContainer']); ?>
