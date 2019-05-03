<?php

namespace app\modules\admin\controllers;

use yii;
use yii\web\Controller;
/**
 * Default controller for the `admin` module
 */
class DefaultController extends CommonController
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $data = '';
        return $this->render('index',['data' => $data]);
    }
    public function actionAdminSing()
    {
        $items = [
            'name' => 'admin/default/admin-sing',
            'description' => '账号设置',
            'type' => '2'
        ];
        print_r($items);
    }
}
