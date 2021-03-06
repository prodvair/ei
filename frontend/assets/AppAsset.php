<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        // 'https://fonts.googleapis.com/css?family=Playfair+Display:400,400i,700,700i|Source+Sans+Pro:200,200i,300,300i,400,400i,600,600i,700,700i,900,900i&display=swap',
        

        'css/data_picker.css',
        'css/custom.min.css',
        'https://cdnjs.cloudflare.com/ajax/libs/fotorama/4.6.4/fotorama.css'
    ];
    public $js = [
        'js/jquery-2.2.4.min.js',
        'js/plugins.js',
        'js/costom-plugins/toast.js',
        'js/custom-core.js?v=1.02',
        'https://cdnjs.cloudflare.com/ajax/libs/fotorama/4.6.4/fotorama.js',
        'http://api-maps.yandex.ru/2.1-stable/?load=package.standard&lang=ru-RU',
        'https://cdn.jsdelivr.net/npm/vue/dist/vue.js',
        'js/data_picker.js',
        'js/scripts.min.js?v=2.11',
    ];
    public $depends = [
        // 'yii\web\YiiAsset',
        // 'yii\bootstrap\BootstrapAsset',
    ];
    public $jsOptions = ['position' => \yii\web\View::POS_HEAD];
}
