<?php
namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class LoginAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'dist/css/bootstrap.min.css',
        'dist/css/AdminLTE.min.css',
        'dist/font-awesome.min.css',
        //'//code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css',
        
    ];
    public $js = [
        'dist/jquery-2.2.3.min.js',
        'dist/bootstrap.min.js',
       
    ];
    public $depends = [
      
    ];
}
?>