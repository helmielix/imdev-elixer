<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = ($name == 'Forbidden (#403)'?'Forbidden':$name);
?>
<div class="site-error">

    <h1><?= Html::encode(($name == 'Forbidden (#403)'?'':$name)) ?></h1>

    <div class="alert alert-danger">
        <?= nl2br(Html::encode(($name == 'Forbidden (#403)'? 'Anda tidak mendapat hak akses membuka page ini. Silahkan kontak IT bagian IDM untuk mengajukan penambahan akses.':$message))) ?>
    </div>

    <p>
		<?= ($name == 'Forbidden (#403)'? '':'The above error occurred while the Web server was processing your request.') ?>
        
    </p>
    <p>
		<?= ($name == 'Forbidden (#403)'? '':'Please contact us if you think this is a server error. Thank you.') ?>
       
    </p>

</div>
