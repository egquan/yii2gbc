<?php
use admin\components\MenuHelper;
use admin\widgets\Menu;
?>
<?php
$callback = function($menu){
    $items = $menu['children'];
    $return = [
        'label' => $menu['name'],
        'url' => [$menu['route']],
    ];
    if(isset($menu['icon'])){
        $return['icon'] = $menu['icon'];
    }else{
        $return['icon'] = 'fa fa-circle-o';
    }
    $items && $return['items'] = $items;
    return $return;
};

$menu = Menu::widget([
    'options' => ['class' => 'layui-nav layui-nav-tree'],
    'items' => MenuHelper::getAssignedMenu(Yii::$app->admin->id, null, $callback),
]);
?>

<div class="layui-side layui-bg-black top-50 nav-top">
    <div class="navBar layui-side-scroll"><?=$menu?></div>
</div>
