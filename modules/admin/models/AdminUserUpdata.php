<?php
/**
 * Created by PhpStorm.
 *FileName: AdminUserUpdata.php
 * User: HR
 * Date: 2019/5/4
 * Time: 4:59
 */
namespace app\modules\admin\models;

use yii\db\ActiveRecord;

class AdminUserUpdata extends ActiveRecord
{
    public $username;
    public $password;
    public $email;
    public $nickname;
    public $head_pic;

    public function attributeLabels()
    {
        return [
            'username' => '管理员账号',
            'password' => '管理员密码',
            'email' => '邮箱',
            'nickname' => '昵称',
            'head_pic' => '头像'
        ];
    }

    public function AdminUserUpdata()
    {
        /*            $id = '1';
                    $user = AdminUser::find()->where(['id'=>$id])->one();
                    $user->email = $this->email; //修改age属性值
                    $user->save(false);*/
        return $this->email;
    }
}