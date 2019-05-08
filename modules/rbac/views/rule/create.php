<?php

use app\assets\GbcAdminAsset;

GbcAdminAsset::register($this);
?>
<div class="auth-item-create">
    <?=$this->render('_form', [
        'model' => $model,
    ]);
    ?>

</div>
