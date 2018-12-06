<?php

namespace common\models;

use Yii;
use yii\base\Model;

class UploadForm extends Model
{
    public $file;

    public function rules()
    {
        return [
            [['file'], 'required'],
			[['file'], 'file',  'extensions' => 'xls,xlsx', 'maxSize'=>1024*1024*5, 'on'=>'xls'],
			// [['file'], 'file',  'extensions' => 'xlsx', 'maxSize'=>1024*1024*5, 'on'=>'olt'],
        ];
    }

}
