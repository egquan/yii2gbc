<?php
/**
 * Created by PhpStorm.
 * User: xiaogang
 * Date: 2019/4/10
 * Time: 22:14
 */
use yii\helpers\Html;
use yii\helpers\Url;
use app\assets\AdminAsset;
$this->title = 'GBC 音乐管理系统后台-首页';
AdminAsset::register($this);
$this->beginPage();
?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <link href="/layui/css/layui.css" rel="stylesheet">
    <link href="/css/admin.css" rel="stylesheet">
    </head>
<?php $this->beginBody() ?>
<body class="layui-layout-body">
    <div class="layui-layout layui-layout-admin">
        <div class="layui-header">
            <div class="layui-logo">GBC 音乐管理系统</div>
            <!-- 头部区域（可配合layui已有的水平导航） -->
            <ul class="layui-nav layui-layout-left">
                <li class="layui-nav-item"><a href="">控制台</a></li>
                <li class="layui-nav-item"><a href="">商品管理</a></li>
                <li class="layui-nav-item"><a href="">用户</a></li>
                <li class="layui-nav-item"><a href="javascript:;">其它系统</a>
                <dl class="layui-nav-child">
                    <dd><a href="">邮件管理</a></dd>
                    <dd><a href="">消息管理</a></dd>
                    <dd><a href="">授权管理</a></dd>
                </dl>
                </li>
            </ul>
            <ul class="layui-nav layui-layout-right">
                <li class="layui-nav-item"><a href="javascript:;"><img src="http://t.cn/RCzsdCq" class="layui-nav-img"><?php if(!Yii::$app->admin->isGuest){Yii::$app->admin->identity->username;}?></a>
                    <dl class="layui-nav-child">
                    <dd><a href="<?php echo Url::to('/admin/public/admindata')?>">基本资料</a></dd></li>
                <li class="layui-nav-item"><?= Html::a('退出','/admin/public/logout',[
                        'data' => [
                                'method' => 'post'
                        ]
                    ])?></li>
            </ul>
        </div>
        <div class="layui-side layui-bg-black">
            <div class="layui-side-scroll">
                <!-- 左侧导航区域（可配合layui已有的垂直导航） -->
                <ul class="layui-nav layui-nav-tree"  lay-filter="test">
                    <li class="layui-nav-item layui-nav-itemed">
                        <a class="" href="javascript:;">所有商品</a>
                        <dl class="layui-nav-child">
                            <dd><a href="javascript:;">列表一</a></dd>
                            <dd><a href="javascript:;">列表二</a></dd>
                            <dd><a href="javascript:;">列表三</a></dd>
                            <dd><a href="">超链接</a></dd>
                        </dl>
                    </li>
                    <li class="layui-nav-item">
                        <a href="javascript:;">解决方案</a>
                        <dl class="layui-nav-child">
                            <dd><a href="javascript:;">列表一</a></dd>
                            <dd><a href="javascript:;">列表二</a></dd>
                            <dd><a href="">超链接</a></dd>
                        </dl>
                    </li>
                    <li class="layui-nav-item"><a href="">云市场</a></li>
                    <li class="layui-nav-item"><a href="">发布商品</a></li>
                </ul>
            </div>
        </div>
        <div class="layui-body">
            <!-- 内容主体区域 -->
            <?= $content?>
        </div>
        <div class="layui-footer">
        <!-- 底部固定区域 -->
        &copy; My Company <?= date('Y') ?> - <?= Yii::powered() ?>
        </div>
    </div>
    <?php $this->endBody() ?>
    <script>
        //JavaScript代码区域
        layui.use('element', function(){
            var element = layui.element;

        });
    </script>
</body>
</html>
<?php $this->endPage() ?>