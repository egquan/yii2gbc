<?php

use app\assets\GbcAdminAsset;

GbcAdminAsset::register($this);
?>
<div class="menu-create">
    <?=
    $this->render('_form', [
        'model' => $model,
    ])
    ?>

</div>
