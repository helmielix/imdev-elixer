<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "labor_temp".
 *
 * @property string $nik
 * @property string $name
 * @property string $position
 * @property string $division
 * @property string $email
 */
class LaborTemp extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'labor_temp';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nik'], 'required'],
            [['nik'], 'string', 'max' => 16],
            [['name', 'position'], 'string', 'max' => 50],
            [['email'], 'string', 'max' => 60],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'nik' => 'Nik',
            'name' => 'Name',
            'position' => 'Position',
            'division' => 'Division',
            'email' => 'Email',
        ];
    }
}
