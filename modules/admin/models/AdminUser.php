<?php

namespace app\modules\admin\models;

use Yii;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
/**
 * This is the model class for table "{{%admin_user}}".
 *
 * @property int $id 管理员ID
 * @property string $username 管理员账号
 * @property string $auth_key
 * @property string $password 管理员密码
 * @property string $password_reset_token
 * @property string $email 管理员邮箱
 * @property string $nickname 昵称
 * @property string $head_pic 头像
 * @property int $status 账号状态
 * @property int $created_time 帐号创建时间
 * @property int $updated_at 资料更新时间
 * @property int $login_time 账号修改时间
 * @property int $login_ip 最后登陆IP
 * @property string $verification_token
 * @property int $role
 */
class AdminUser extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_INACTIVE = 9;
    const STATUS_ACTIVE = 10;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%admin_user}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['status', 'default', 'value' => self::STATUS_INACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE, self::STATUS_DELETED]],
            [['email', 'nickname', 'head_pic'], 'required', 'message' => '{attribute}不能为空', 'on' => 'updatas'],
            ['email', 'email', 'message' => '邮箱格式不正确', 'on' => 'updates'],
            ['email', 'unique', 'message' => '邮箱格已被占用', 'on' => 'updates'],
            ['nickname', 'string', 'max' => 10, 'message' => '{attribute}不能大于10个字符', 'on' => 'updates'],
            ['head_pic', 'url', 'message' => '{attribute}必须为URL形式', 'on' => 'updates'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => '管理员账号',
            'auth_key' => 'Auth Key',
            'password' => '管理员密码',
            'password_reset_token' => 'Password Reset Token',
            'email' => '邮箱',
            'status' => '账号状态',
            'created_time' => 'Created Time',
            'login_time' => '登录时间',
            'login_ip' => '登陆IP',
            'verification_token' => 'Verification Token',
            'role' => 'Role',
            'verifyCode' => '验证码',
            'rememberMe' => '记住登陆',
            'head_pic' => '头像',
            'nickname' => '昵称',
        ];
    }
    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds user by verification email token
     *
     * @param string $token verify email token
     * @return static|null
     */
    public static function findByVerificationToken($token) {
        return static::findOne([
            'verification_token' => $token,
            'status' => self::STATUS_INACTIVE
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    public function generateEmailVerificationToken()
    {
        $this->verification_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    /**
     * 更新资料
     */
    public function Updates($data, $id)
    {
        $this->scenario = 'updates';
        if ($this->load($data) && $this->validate()) {
            $user = $this->findOne($id);
            $user->password = Yii::$app->getSecurity()->generatePasswordHash('admin888');
            $user->email = $this->email;
            $user->nickname = $this->nickname;
            $user->updated_at = time();
            $user->head_pic = $this->head_pic;
            if ($user->save(false)) {
                return true;
            }
            return false;
        }
        return false;
    }
}
