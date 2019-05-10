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
use yii\web\ForbiddenHttpException;
use admin\models\AdminUser;
use admin\models\ChangeForm;
use admin\models\searchs\User as UserSearch;
use admin\models\form\Signup;

use yii\web\Response;

class AdminUserController extends Controller
{
    private $_oldMailPath;
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

    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            if (Yii::$app->has('mailer') && ($mailer = Yii::$app->getMailer()) instanceof BaseMailer) {
                /* @var $mailer BaseMailer */
                $this->_oldMailPath = $mailer->getViewPath();
                $mailer->setViewPath('@mdm/admin/mail');
            }
            return true;
        }
        return false;
    }

    /**
     * @inheritdoc
     */
    public function afterAction($action, $result)
    {
        if ($this->_oldMailPath !== null) {
            Yii::$app->getMailer()->setViewPath($this->_oldMailPath);
        }
        return parent::afterAction($action, $result);
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
            if ($post_data['AdminUser']['password']) {
                $model->password = Yii::$app->security->generatePasswordHash($post_data['AdminUser']['password']);
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
        if ($model->status == AdminUser::STATUS_INACTIVE) {
            return Yii::$app->response->data = ['code' => 400, "msg" => "该用户是已经是禁用状态"];
        }

        $model->status = AdminUser::STATUS_INACTIVE;

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
        if ($model->status == AdminUser::STATUS_ACTIVE) {
            return Yii::$app->response->data = ['code' => 400, "msg" => "该用户是已经是启用状态"];
        }

        $model->status = AdminUser::STATUS_ACTIVE;

        if ($model->save()) {
            return Yii::$app->response->data = ['code' => 200, "msg" => "启用成功"];
        } else {
            $errors = $model->firstErrors;
            return Yii::$app->response->data = ['code' => 400, "msg" => reset($errors)];
        }
    }

    /**
     * 启用用户
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
        $model = new Signup();
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
     * 更新资料弹出
     * Displays update-self page.
     * @param integer $id
     * @return Response|string
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
     * Displays change-password page.
     * @param integer $id
     * @return Response|string
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
     * 图片上传Api接口
     * Upload action.
     * @return Json|array
     */
    public function actionUpload()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
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
                return Yii::$app->response->data = [
                    'code' => $error,
                    'data' =>
                        [
                            'src' => 'http://www.gbc.com/' . $targetFile,
                            'size' => $post['size'],
                        ],
                ];
            }
        }
        return Yii::$app->response->data = [
            'code' => '1',
        ];
    }

    /**
     * 加载模型
     * findModel action
     * @protected
     */
    protected function findModel($id)
    {
        if (($model = AdminUser::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
