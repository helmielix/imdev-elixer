<?php
use yii\helpers\Html;
use yii\helpers\Url;
/* @var $this yii\web\View */

$this->title = 'FORO';
$this->registerJsFile('@web/js/menu.js',['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerCssFile('@web/css/menu.css',['depends' => [\yii\web\JqueryAsset::className()]]);
?>
<div class="site-index">

    <div class="body-content">
    <img src="<?php echo Url::base(); ?>/images/foot.jpg" width="100%" height="100%" style='position:absolute; top: 0px; left: 0px; z-index:-100' />
        <div class="row">
            <div class="col-lg-3">
                <a href="<?php echo 'http://server001:8020/'?>mnc_govrel/backend/web" class="menulinkcontainer govrel">
                <div class="menulinkcircle"> </div>
                    <h3 class="green"> GOVREL </h3>
                </a>
            </div>
            <div class="col-lg-3">
                <a href="<?php echo 'http://server001:8020/'?>mnc_ca/backend/web" class="menulinkcontainer ca">
                <div class="menulinkcircle"> </div>
                    <h3 class="blue"> CA </h3>
                </a>
            </div>
            <div class="col-lg-3">
                <a href="<?php echo 'http://server001:8020/'?>mnc_cc/backend/web" class="menulinkcontainer costcontrol">
                <div class="menulinkcircle"> </div>
                    <h3 class="orange"> Cost Control </h3>
                </a>
            </div>
            <div class="col-lg-3">
                <a href="<?php echo 'http://server001:8020/'?>foro/osp/web" class="menulinkcontainer osp">
                <div class="menulinkcircle"> </div>
                    <h3 class="orange"> OSP </h3>
                </a>
            </div>
        </div>

    </div>
</div>
 