<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "dash_os_outsource_personel".
 *
 * @property integer $id
 * @property string $city
 * @property integer $male_iko
 * @property integer $female_iko
 * @property integer $male_osp
 * @property integer $female_osp
 */
class DashOsOutsourcePersonel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dash_os_outsource_personel';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['city'], 'required'],
            [['male_iko', 'female_iko', 'male_osp', 'female_osp'], 'integer'],
            [['city'], 'string', 'max' => 30],
            [['city'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'city' => 'City',
            'male_iko' => 'Male Iko',
            'female_iko' => 'Female Iko',
            'male_osp' => 'Male Osp',
            'female_osp' => 'Female Osp',
        ];
    }
}
