<?php
/**
 * Created by PhpStorm.
 * User: xiaogang
 * Date: 2019/4/8
 * Time: 0:51
 */

namespace admin\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use admin\models\LoginForm;
class PublicController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
                'minLength' => 4,
                'maxLength' => 4
            ],
        ];
    }
    /**
     * 登陆
     * Login action.
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->admin->isGuest) {
            return $this->redirect(['default/index']);
        }
        $this->layout = false;
        $model = new LoginForm();
        $model->loginCaptchaRequired();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            //登录成功跳转
            return $this->redirect(['default/index']);
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }
    /**
     * 退出登陆
     * Logout action.
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->admin->logout();

        return $this->redirect(['public/login']);
    }

    public function actionCs(){
        $mail = Yii::$app->mailer->compose();
        $mail->setTo('egquan@163.com');
        $mail->setSubject("邮件测试");
//$mail->setTextBody('zheshisha ');   //发布纯文字文本
        $mail->setHtmlBody("<br>问我我我我我");    //发布可以带html标签的文本
        if ($mail->send())
            echo "success";
        else
            echo "failse";
        die();
    }
}