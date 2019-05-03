<?php

namespace app\modules\admin;

use yii;
/**
 * admin module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\admin\controllers';
    public $widgetsNamespace = 'app\modules\admin\widgets';
    public $layout = 'admin-main';
    public $mainLayout = '@admin/views/layouts/main.php';
    public $navbar;
    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        if ($this->navbar === null && Yii::$app instanceof yii\web\Application) {
            $this->navbar = [
                ['label' => '帮助', 'url' => ['default/index']],
                ['label' => '首页', 'url' => Yii::$app->homeUrl],
            ];
        }

        // custom initialization code goes here
    }
}
