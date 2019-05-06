<?php

namespace app\modules\admin\controllers;
/**
 * Created by PhpStorm.
 * User: xiaogang
 * Date: 2019/4/20
 * Time: 22:25
 */

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use app\modules\admin\models\AdminUser;
use app\modules\admin\models\ChangeForm;
use yii\web\Response;
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
            $model->updated_at = time();
            if ($model->save(false)) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            return $this->render('updateself', [
                'model' => $model,
            ]);
        }
        return false;
    }
    /**
     * 修改密码
     */
    public function actionChangePassword($id)
    {
        $model = new ChangeForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($id != Yii::$app->admin->identity->id) {
                throw new ForbiddenHttpException('非本用户操作，被拒绝！');
            }
            $model->updated_at = time();
            $admin = Yii::$app->admin->identity;
            $admin->password = Yii::$app->security->generatePasswordHash($model->newpassword);
            if ($admin->save()) {
                // 修改成功退出登陆返回登录界面
                Yii::$app->admin->logout();
                return $this->redirect(['public/login']);
            }
        }
        return $this->render('changepassword', [
            'model' => $model,
        ]);

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

    /**
     * 头像上传
     */
    public function actionUpload()
    {
        if (!empty($_FILES['Upload']) && $_FILES['Upload']['error'] === 0) {
            $post = $_FILES['Upload'];
            $filenames = explode(".", $post['name']);
            $tempFile = $post['tmp_name'];
            $path = 'uploads/';
            if (!is_dir($path)) {
                mkdir($path, '0777', true);
            }
            $targetFile = $path . time() . "." . $filenames[count($filenames) - 1]; //图片完整路徑
            // Validate the file type
            $fileTypes = array('jpg', 'jpeg', 'png', 'gif'); // File extensions
            $fileParts = pathinfo($post['name']);
            if (in_array($fileParts['extension'], $fileTypes)) {
                $error = '0';
                move_uploaded_file($tempFile, $targetFile);
                Yii::$app->response->format = Response::FORMAT_JSON;
                return Yii::$app->response->data = [
                    'code' => $error,
                    'data' =>
                        [
                            'src' => 'http://127.0.0.1/' . $targetFile,
                            'size' => $post['size'],
                        ],
                ];
            }
        }
        Yii::$app->response->format = Response::FORMAT_JSON;
        return Yii::$app->response->data = [
            'code' => '1',
        ];
    }
}
