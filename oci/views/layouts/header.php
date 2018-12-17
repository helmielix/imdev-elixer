<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;

/* @var $this \yii\web\View */
/* @var $content string */
?>

<header class="main-header">

    <a href="<?=Yii::$app->homeUrl?>" class="logo">
			<span class="logo-mini"><?= Html::img('@commonpath/images/logo_mnc_play_small.png', $options=['style'=>"height: 46px; width: 46px;"])?></span>
			<div class="logo-lg">
				<?= Html::img('@commonpath/images/logo_mnc_play_large.png', $options=["class"=>"mainLogo"]) ?>
				<!-- <div class="logoText">
					<span class="mainText"> OS </span>
					<span class="subText" style='font-size:9px'> Operation Support </span>
				</div> -->
			</div>
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
