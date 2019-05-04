<?php

namespace app\modules\admin\controllers;
/**
 * Created by PhpStorm.
 * User: xiaogang
 * Date: 2019/4/20
 * Time: 22:25
 */
use yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use app\modules\admin\models\AdminUser;
class AdminUserController extends Controller
{
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
     * 更新资料
     */
    public function actionUpdateSelf($id)
    {
        $model = $this->findModel($id);
        $post_data = Yii::$app->request->post();

        if($id!=Yii::$app->admin->identity->id){
            throw new ForbiddenHttpException('你没有权限修改');
        }
        if ($model->load($post_data) && $model->validate()) {
            if ($post_data['AdminUser']['password']) {
                $model->password = Yii::$app->security->generatePasswordHash($post_data['AdminUser']['password']);
            }
            $model->password_reset_token = null;
            $model->updated_at = time();
            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            return $this->render('updateself', [
                'model' => $model,
            ]);
        }
    }
    /**
     * 加载模型
    */
    protected function findModel($id)
    {
        if (($model = AdminUser::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    /**
     * 资料浏览
    */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }
}