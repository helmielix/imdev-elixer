<?php
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this \yii\web\View */
/* @var $content string */
?>

<header class="main-header">

    <a href="<?=Yii::$app->homeUrl?>" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <!-- <span class="logo-mini"><img src="<?php echo Url::base()."/images/logo_kecil_2.png";?>" style="height: 55px;"></span> -->
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><img src="<?php echo Url::base()."/images/MNC_logo.png";?>" style="height: 39px;"></span>
    </a>

    

    <nav class="navbar navbar-static-top" role="navigation">

        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>      
        
    <h4 style="float:left; color: white; font-size: 27px"><?= Html::encode($this->title)?></h4>

        <div class="navbar-custom-menu">
            <ul class="nav nav-bar">
                <?php if (!Yii::$app->user->isGuest) {
                        echo '<li>'
                            . Html::beginForm(['/site/logout'], 'post')
                            . Html::submitButton(
                                'Logout (' . Yii::$app->user->identity->username . ')',
                                ['class' => 'btn btn-primary logout']
                            )
                            . Html::endForm()
                            . '</li>';
                } else {
                    echo '<li>'
                            . Html::beginForm(['/site/login'], 'post')
                            . Html::submitButton(
                                'Login',
                                ['class' => 'btn btn-primary logout']
                            )
                            . Html::endForm()
                            . '</li>';
                }?>
            </ul>
        </div>
    </nav>
</header>
