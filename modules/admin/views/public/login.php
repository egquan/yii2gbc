<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\captcha\Captcha;
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title>GBC 音乐管理系统后台</title>
        <link href="/layui/css/layui.css" rel="stylesheet">
        <link href="/css/admin.css" rel="stylesheet">
    </head>
    <body class="layui-layout-body">
    <div class="layui-layout gbc-admin-empty">
        <!-- 内容主体区域 -->
        <div class="layui-body">
            <div class="gbc-admin-login">
                <div class="admin-login-box">
                    <h2>GBC 音乐管理系统</h2>
                </div>
                <?php $form = ActiveForm::begin([
                    'id' => 'login-form',
                    'options' => [
                        'class' => 'layui-form'
                    ],
                    'fieldConfig' => [
                        'template' => "<div class=\"layui-form-item\">{input}</div>\n<blockquote>{error}</blockquote>",
                    ],
                ]); ?>
                <label class="layui-icon layui-icon-username admin-icon-username" for="loginform-username"></label>
                <?= $form->field($model, 'username')->textInput(['autofocus' => true,'class'=>'layui-input admin-login-input','placeholder'=>'账号']) ?>
                <label class="layui-icon layui-icon-password admin-icon-password" for="loginform-password"></label>
                <?= $form->field($model, 'password')->passwordInput(['class'=>'layui-input admin-password-input','placeholder'=>'密码']) ?>
                <?php
                //三次开启验证码
                if ($model->scenario == 'loginError'){ ?>
                    <label class="layui-icon layui-icon-vercode admin-icon-captcha" for="loginform-verifycode"></label>
                    <?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
                    'captchaAction' => '/admin/public/captcha',
                    'options' => [
                        'class' => 'layui-input admin-input-captcha',
                        'style' => '',
                        'placeholder' => '输入验证码',
                    ],
                    'template' => '{input}&nbsp;&nbsp;{image}',
                    'imageOptions' => [
                        'style' => 'max-height:38px;',
                        'options' => ['class' => 'admin-captcha']
                    ]
                ]) ?>

                <?php } ?>
                <?= $form->field($model, 'rememberMe')->checkbox([
                    'lay-skin' => 'primary',
                    'title' => '记住密码'
                ],false) ?>
                <?= Html::submitButton('登入', ['class' => 'layui-btn layui-btn-fluid', 'name' => 'login-button']) ?>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
    <?php
    //注册JS
    $this->registerJsFile('/layui/layui.all.js',
        ['depends'=>'yii\web\YiiAsset','position'=>\yii\web\View::POS_END]);
    ?>
    <?php $this->endBody()?>
    </body>
    </html>
<?php $this->endPage() ?>