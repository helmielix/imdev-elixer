<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "dash_os_ga".
 *
 * @property integer $id
 * @property string $city
 * @property string $month
 * @property string $year
 * @property integer $sum_stdk
 */
class DashOsGa extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dash_os_ga';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sum_stdk'], 'integer'],
            [['city'], 'string', 'max' => 30],
            [['month'], 'string', 'max' => 2],
            [['year'], 'string', 'max' => 4],
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
            'month' => 'Month',
            'year' => 'Year',
            'sum_stdk' => 'Sum Stdk',
        ];
    }
}
