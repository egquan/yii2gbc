<?php
use app\assets\GbcAdminAsset;
GbcAdminAsset::register($this);
$this->registerJs($this->render('js/create.js'));
?>
<div class="user-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
