<?php

namespace admin\controllers;
/**
 * Created by PhpStorm.
 * User: xiaogang
 * Date: 2019/4/20
 * Time: 22:25
 */

use Yii;
use yii\helpers\Json;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use app\models\User;
use admin\models\form\UserSignup;
use admin\models\searchs\User as UserSearch;
use yii\web\Response;

/**
 * AdminUser Controller
 */
class UserController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                    'active' => ['post'],
                    'inactive' => ['post'],
                    'Active' => ['post'],
                ],
            ],
        ];
    }

    /**
     * 首页
     * Displays index page.
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * 资料浏览
     * @param integer $id
     * Displays view page.
     * @return string
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * 更新资料
     * Displays update page.
     * @param integer $id
     * @return Response|string
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $post_data = Yii::$app->request->post();


        if ($model->load($post_data) && $model->validate()) {
            if ($post_data['User']['password_hash']) {
                $model->password_hash = Yii::$app->security->generatePasswordHash($post_data['User']['password_hash']);
            }
            $model->password_reset_token = null;
            $model->updated_at = time();
            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * 禁用用户
     * Inactive action.
     * @param integer $id
     * @return Json|array
     */
    public function actionInactive($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $model = $this->findModel($id);
        if ($model->status == User::STATUS_INACTIVE) {
            return Yii::$app->response->data = ['code' => 400, "msg" => "该用户是已经是禁用状态"];
        }

        $model->status = User::STATUS_INACTIVE;

        if ($model->save()) {
            return Yii::$app->response->data = ['code' => 200, "msg" => "禁用成功"];
        } else {
            $errors = $model->firstErrors;
            return Yii::$app->response->data = ['code' => 400, "msg" => reset($errors)];
        }
    }

    /**
     * 启用用户
     * Active action.
     * @param integer $id
     * @return Json|array
     */
    public function actionActive($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $model = $this->findModel($id);
        if ($model->status == User::STATUS_ACTIVE) {
            return Yii::$app->response->data = ['code' => 400, "msg" => "该用户是已经是启用状态"];
        }

        $model->status = User::STATUS_ACTIVE;

        if ($model->save()) {
            return Yii::$app->response->data = ['code' => 200, "msg" => "启用成功"];
        } else {
            $errors = $model->firstErrors;
            return Yii::$app->response->data = ['code' => 400, "msg" => reset($errors)];
        }
    }

    /**
     * 删除用户
     * Delete action.
     * @param integer $id
     * @return Json|array
     */
    public function actionDelete($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if ($this->findModel($id)->delete()) {
            return Yii::$app->response->data = ['code' => 200, "msg" => "删除成功"];
        } else {
            return Yii::$app->response->data = ['code' => 400, "msg" => "删除失败"];
        }
    }

    /**
     * 添加用户 还未完成
     * Displays update page.
     * @param integer $id
     * @return Response|string
     */
    public function actionSignup()
    {
        $model = new UserSignup();
        if ($model->load(Yii::$app->getRequest()->post())) {
            if ($user = $model->signup()) {
                return $this->render('view', [
                    'model' => $user,
                ]);
            }
        }
        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * 加载模型
     * findModel action
     * @protected
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
