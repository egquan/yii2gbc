<?php
/**
 * Created by PhpStorm.
 * User: xiaogang
 * Date: 2019/5/5
 * Time: 9:50
 */

namespace admin\models;

use Yii;
use yii\base\Model;

/*
 * @property string $password 管理密码
 * @property string $newpassword 管理员新密码
 * @property string $newspassword 管理员确认密码
 * @property int $updated_at 管理员确认密码
 * @property object $_admin
 */

class ChangeForm extends Model
{
    public $password;
    public $newpassword;
    public $newspassword;
    public $updated_at;
    private $_admin = null;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            //[['password', 'newpassword', 'newspassword'], 'filter', 'filter' => 'trim'],
            [['password', 'newpassword', 'newspassword'], 'required'],
            ['newspassword', 'compare', 'compareAttribute' => 'newpassword', 'message' => '确认密码错误，与新密码不一致！'],
            ['password', 'validatePassword'],
            ['newspassword', 'notCompare'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'password' => '原始密码',
            'newpassword' => '新密码',
            'newspassword' => '确认新密码',
        ];
    }

    /**
     * 验证原密码是否正确
     *
     * @param $attribute
     * @param $params
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, '原密码不正确');
            }
        }
    }

    /**
     * 获取用户信息
     *
     * @return AdminUser|null
     */
    protected function getUser()
    {
        if ($this->_admin === null) {
            $this->_admin = AdminUser::findByUsername(Yii::$app->admin->identity->username);
        }

        return $this->_admin;
    }

    /**
     * 新密码不能和原密码相同
     * @param $attribute
     */
    public function notCompare($attribute)
    {
        if ($this->password == $this->newpassword) {
            $this->addError($attribute, '新密码不能和原密码相同');
        }
    }
}
