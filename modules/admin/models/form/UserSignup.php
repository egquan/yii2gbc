<?php

namespace admin\models\form;

use Yii;
use app\models\User;
use yii\base\Model;

/**
 * UserSignup form
 */
class UserSignup extends Model
{
    public $username;
    public $nickname;
    public $avatar;
    public $email;
    public $password_hash;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            [['username', 'nickname'], 'required', 'message' => '{attribute}不能为空！'],
            ['nickname', 'string', 'max' => 10, 'message' => '昵称不能大于10个字'],
            ['username', 'unique', 'targetClass' => 'app\models\User', 'message' => '账号已存在！'],
            [['username', 'avatar'], 'string', 'min' => 5, 'max' => 255],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => 'app\models\User', 'message' => '邮箱已存在！'],

            ['password_hash', 'required'],
            ['password_hash', 'string', 'min' => 8, 'message' => '密码最少8个字符'],
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
            $user = new User();
            $user->username = $this->username;
            $user->nickname = $this->nickname;
            $user->avatar = $this->avatar;
            $user->email = $this->email;
            $user->created_at = time();
            $user->login_ip = ip2long(Yii::$app->request->userIP);
            $user->setPassword($this->password_hash);
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
            'avatar' => '用户头像',
            'email' => '电子邮箱',
            'password_hash' => '用户密码',
        ];
    }
}