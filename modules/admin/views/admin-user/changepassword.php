<?php
/**
 * Created by PhpStorm.
 * User: xiaogang
 * Date: 2019/5/5
 * Time: 9:54
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\assets\GbcAdminAsset;

GbcAdminAsset::register($this);
$this->registerJs($this->render('js/create.js'));
?>
<div class="user-update">
    <div class="user-form create_box">
        <?php $form = ActiveForm::begin(['options' => ['class' => 'layui-form']]); ?>
        <?= $form->field($model, 'password')->passwordInput(['maxlength' => true, 'value' => '', 'class' => 'layui-input search_input']) ?>
        <?= $form->field($model, 'newpassword')->passwordInput(['maxlength' => true, 'value' => '', 'class' => 'layui-input search_input']) ?>
        <?= $form->field($model, 'newspassword')->passwordInput(['maxlength' => true, 'value' => '', 'class' => 'layui-input search_input']) ?>
        <?= Html::submitButton('修改', ['class' => 'layui-btn layui-btn-normal']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div>
