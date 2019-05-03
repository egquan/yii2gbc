<?php
/**
 * Created by PhpStorm.
 * User: xiaogang
 * Date: 2019/4/10
 * Time: 22:25
 */

namespace app\assets;

use yii\web\AssetBundle;

class AdminAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'layui/css/layui.css',
        'css/admin.css'
    ];
    public $js = [
        '../layui/layui.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
