<?php
use yii\widgets\DetailView;
use app\assets\GbcAdminAsset;

GbcAdminAsset::register($this);
?>
<div class="user-view">
    <?=DetailView::widget([
        'model' => $model,
        'options' => ['class' => 'layui-table'],
        'attributes' => [
            'username',
            'nickname',
            [
                "attribute"=>"head_pic",
                "format"=>[
                    "image",
                    [
                        "width"=>"100px",
                        "height"=>"100px",
                        "class" => "layui-circle"
                    ],
                ],
            ],
            'email:email',
            'updated_at:datetime',
            [
                'attribute' => 'login_ip',
                'value' => long2ip($model->login_ip),
            ]
        ],
        'template' => '<tr><th width="90px;">{label}</th><td>{value}</td></tr>',
    ])
    ?>
</div>