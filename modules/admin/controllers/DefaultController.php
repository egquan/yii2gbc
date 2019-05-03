<?php

namespace app\modules\admin\controllers;

use Yii;
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
        if(Yii::$app->admin->isGuest){
            return $this->redirect(['/admin/public/login']);
        }
        $data = '';
        return $this->render('index',['data' => $data]);
    }
}
