<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "dash_ca_hp_by_city".
 *
 * @property string $city
 * @property integer $hp_submit
 * @property integer $hp_on_process
 * @property integer $hp_aktif
 * @property integer $hp_rejected
 * @property double $yearmonth
 */
class DashCaHpByCity extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dash_ca_hp_by_city';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['hp_submit', 'hp_on_process', 'hp_aktif', 'hp_rejected'], 'integer'],
            [['yearmonth'], 'number'],
            [['city'], 'string', 'max' => 30],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'city' => 'City',
            'hp_submit' => 'Hp Submit',
            'hp_on_process' => 'Hp On Process',
            'hp_aktif' => 'Hp Aktif',
            'hp_rejected' => 'Hp Rejected',
            'yearmonth' => 'Yearmonth',
        ];
    }
}
