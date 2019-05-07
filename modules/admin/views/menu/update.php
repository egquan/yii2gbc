<?php

use app\assets\GbcAdminAsset;

GbcAdminAsset::register($this);
?>
<div class="menu-update">
    <?=
    $this->render('_form', [
        'model' => $model,
    ])
    ?>

</div>
