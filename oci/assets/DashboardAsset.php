<?php
namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class DashboardAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'dist/css/bootstrap.min.css',
        'dist/css/AdminLTE.min.css',
        '//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css',
        '//code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css',
        'dist/css/skins/_all-skins.min.css',
        'plugins/iCheck/flat/blue.css',
        'css/site.css',
        'css/style.css',
        'css/bootstrap-datepicker.css',
        'css/bootstrap-datepicker.min.css',
        'css/AdminLTE.min.css',
    ];
    public $js = [
        'https://code.jquery.com/ui/1.11.4/jquery-ui.min.js',
        '//code.jquery.com/ui/1.11.4/jquery-ui.min.js',
        '//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js',
        'plugins/sparkline/jquery.sparkline.min.js',
        'plugins/slimScroll/jquery.slimscroll.min.js',
        'plugins/fastclick/fastclick.js',
        'dist/js/app.min.js',
        'dist/js/dashboard.js',
        'dist/js/bootstrap-datepicker.js',
        'dist/js/bootstrap-datepicker.min.js',
       
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
?>