<?php

namespace admin\models\form;

use Yii;
use admin\models\AdminUser;
use yii\base\Model;

/**
 * AdminSignup form
 */
class AdminSignup extends Model
{
    public $username;
    public $nickname;
    public $head_pic;
    public $email;
    public $password;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required', 'message' => '用户账号不能为空！'],
            ['nickname', 'string', 'max' => 10, 'message' => '昵称不能大于10个字'],
            ['username', 'unique', 'targetClass' => 'admin\models\AdminUser', 'message' => '用户账号已存在！'],
            [['username', 'head_pic'], 'string', 'min' => 2, 'max' => 255],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => 'admin\models\AdminUser', 'message' => '邮箱已存在！'],

            ['password', 'required'],
            ['password', 'string', 'min' => 8, 'message' => '密码最少8个字符'],
        ];
    }

    /**
     * Signs user up.
     *
     * @return AdminUser|null the saved model or null if saving fails
     */
    public function signup()
    {
        if ($this->validate()) {
            $user = new AdminUser();
            $user->username = $this->username;
            $user->nickname = $this->nickname;
            $user->head_pic = $this->head_pic;
            $user->email = $this->email;
            $user->created_at = time();
            $user->login_ip = ip2long(Yii::$app->request->userIP);
            $user->setPassword($this->password);
            $user->generateAuthKey();
            if ($user->save()) {
                return $user;
            }
        }

        return null;
    }

    public function attributeLabels()
    {
        return [
            'nickname' => '用户名',
            'username' => '用户账号',
            'head_pic' => '用户头像',
            'email' => '电子邮箱',
            'password' => '用户密码',
        ];
    }
}
