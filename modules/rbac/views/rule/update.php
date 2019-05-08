<?php

use app\assets\GbcAdminAsset;

GbcAdminAsset::register($this);
?>
<div class="auth-item-update">
    <?=$this->render('_form', [
        'model' => $model,
    ]);
    ?>
</div>
