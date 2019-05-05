<?php
/**
 * Created by PhpStorm.
 * User: xiaogang
 * Date: 2019/5/5
 * Time: 14:11
 */

namespace app\modules\admin\models;

use yii\base\Model;
use yii\web\UploadedFile;

class UploadForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $file;

    public function rules()
    {
        return [
            [['file'], 'file', 'extensions' => 'jpg, png', 'mimeTypes' => 'image/jpeg, image/png',],
        ];
    }

    public function attributeLabels()
    {
        return [
            'file' => '文件上传'
        ];
    }
}