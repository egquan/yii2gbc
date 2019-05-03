<?php
/**
 * Created by PhpStorm.
 *FileName: AdminUserUpdata.php
 * User: HR
 * Date: 2019/5/4
 * Time: 4:59
 */
namespace app\modules\admin\models;

use yii\base\Model;
class AdminUserUpdata extends AdminUser
{
    public function AdminUserUpdata($id,$data) {
        $user = AdminUserUpdata::find()->where(['id'=>$id])->one(); //获取name等于test的模型
        $user->email = $data['AdminUserUpdata']['email']; //修改age属性值
        if($user->save(false)){
            return true;
        }
        return false;
    }
}