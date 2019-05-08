<?php

namespace admin\controllers;

use Yii;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;

class CommonController extends Controller
{
    public $whitelist = [
        'admin/public/login',
        'admin/public/captcha',
    ];
/*    public function init()
    {
        if (Yii::$app->admin->isGuest) {
            return $this->redirect(['/admin/public/login']);
        }
    }*/

    /**
     * 在程序执行之前，对访问的方法进行权限验证.
     * @param \yii\base\Action $action
     * @return bool
     * @throws ForbiddenHttpException
     */
    private function flash()
    {
        if($this->route == 'site/close-win') {
            return;
        }
        $levels = [0=>'warning',1=>'success',2=>'fail',6=>'info'];
        foreach ($levels as $icon => $level) {
            if(Yii::$app->session->hasFlash($level))
            {
                $msg = Yii::$app->session->getFlash($level);
                $this->getView()->registerJs("
                    layer.msg(\"$msg\", {icon: $icon});
                ");
            }
        }
    }

    public function beforeAction($action)
    {
        $this->flash();
        //如果未登录，则直接返回
        if(Yii::$app->admin->isGuest){
            return $this->redirect(['/admin/public/login']);
        }
        //获取路径
        $path = Yii::$app->request->pathInfo;

        //忽略列表
        if (in_array($path, $this->whitelist)) {
            return true;
        }

        if (Yii::$app->admin->can($path)) {
            return true;
        } else {
            throw new ForbiddenHttpException(Yii::t('app', 'message 401'));
        }
    }
}