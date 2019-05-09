<?php

/**
 * Yii bootstrap file.
 * Used for enhanced IDE code _ide_header.
 */
class Yii extends \yii\BaseYii
{
    /**
     * @var _ide_header the application instance
     */
    public static $app;
}


/**
 * Class WebApplication
 * Include only Web application related components here
 *
 * @property admin\models\AdminUser $admin admin modules.
 */
class _ide_header extends yii\web\Application
{
}