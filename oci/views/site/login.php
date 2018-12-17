<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;



$this->title = 'Login';
?>

  <img src="<?php echo Yii::getAlias("@commonpath"); ?>/images/background_login.jpg" width="100%" height="100%" style='position:absolute; top: 0px; left: 0px; z-index:-100' />
  <div class="login-logo">
    <b style="color:white">LOGIN</b>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body" style="background-color: rgba(255,255,255,0.9)">
    <p class="login-box-msg">Sign in to start your session</p>

    <!--form action="../../index2.html" method="post"-->
    <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
      <div class="form-group has-feedback">
        <?= $form->field($model, 'username', [
           'inputOptions' => ['autofocus' => 'autofocus', 'class' => 'form-control']
     ])->textInput(['autofocus' => true],['placeholder' => "Enter Your Email"])?>
        <!--input type="email" class="form-control" placeholder="Email" autofocus="autofocus" name="username"-->
        <!--span class="glyphicon glyphicon-envelope form-control-feedback"></span-->
      </div>
      <div class="form-group has-feedback">
        <?= $form->field($model, 'password', ['inputOptions' => ['class' => 'form-control']
     ])->passwordInput(['placeholder' => "Enter Your Password"]) ?>
        <!--input type="password" class="form-control" placeholder="Password" name="username"-->
        <!--span class="glyphicon glyphicon-lock form-control-feedback"></span-->
      </div>
      <div class="row">
        <div class="col-xs-8">
          <?= Html::a(\Yii::t('app','Back'), Yii::$app->homeUrl ,['id'=>'backButton','class' => 'btn btn-info btn-flat']) ?>
          <div class="checkbox icheck">
            <!--label>
              <input type="checkbox"> Remember Me
            </label-->
          </div>
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <!--button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button-->
          <?= Html::submitButton('Login', ['class' => 'btn btn-primary btn-block btn-flat', 'name' => 'login-button']) ?>
        </div>
        <!-- /.col -->
      </div>
    <!--/form-->
    <?php ActiveForm::end(); ?>
