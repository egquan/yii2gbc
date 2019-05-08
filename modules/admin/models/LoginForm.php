<?php
/**
 * Created by PhpStorm.
 * User: xiaogang
 * Date: 2019/4/12
 * Time: 12:14
 */

namespace admin\models;

use Yii;
use yii\base\Model;
/**
 * LoginForm is the model behind the login form.
 */
class LoginForm extends Model
{
    public $username;
    public $password;
    public $rememberMe = false;
    public $verifyCode;
    public $attempts = 3;
    private $_admin = null;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['username', 'password'], 'required'],
            ['rememberMe', 'boolean'],
            ['password', 'validatePassword'],
            ['verifyCode','captcha','captchaAction'=>'admin/public/captcha','message'=>'{attribute}错误','on' => 'loginError'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => '管理员账号',
            'password' => '管理员密码',
            'verifyCode' => '验证码',
            'rememberMe' => '记住登陆',
        ];
    }
    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, '用户名或密码错误');
            }
        }
    }
    /**
     * 验证码判断
     */
    public function loginCaptchaRequired()
    {
        if (Yii::$app->session->get('login_error_times') >= $this->attempts)
        {
            $this->setScenario('loginError');
        }
    }
    /**
     * Logs in a user using the provided username and password.
     * @return boolean whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate() && Yii::$app->admin->login($this->getUser(), $this->rememberMe ? 3600*24*30 : 0)){
            Yii::$app->session->remove('login_error_times');
            return true;
        }
        $counter = Yii::$app->session->get('login_error_times') + 1;
        Yii::$app->session->set('login_error_times', $counter);
        return false;
    }

    /**
     * Finds user by [[username]]
     *
     * @return AdminUser|null
     */
    public function getUser()
    {
        if ($this->_admin === null) {
            $this->_admin = AdminUser::findByUsername($this->username);
        }
        return $this->_admin;
    }
}
