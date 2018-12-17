<?php
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */

common\assets\AppAsset::register($this);
dmstr\web\AdminLteAsset::register($this);

$directoryAsset = Yii::$app->assetManager->getPublishedUrl('@vendor/almasaeed2010/adminlte/dist');
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
	<link rel="icon" href="../favicon.ico" type="image/x-icon" />
	<meta charset="<?= Yii::$app->charset ?>"/>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?= Html::csrfMetaTags() ?>
	<title><?= Html::encode($this->title) ?></title>
	<?php $this->head() ?>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<?php $this->beginBody() ?>
<div class="wrapper">

	<?= $this->render(
		'header.php',
		['directoryAsset' => $directoryAsset]
	) ?>

	<?= $this->render(
		'left.php',
		['directoryAsset' => $directoryAsset]
	)
	?>

	<div class="content-wrapper">
		<?= $content ?>
	</div>

</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
