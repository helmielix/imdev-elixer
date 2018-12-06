<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "log_ca_parameter_statis".
 *
 * @property integer $idlog
 * @property string $property_area_type
 * @property string $house_type
 * @property string $avr_occupancy_rate
 * @property string $myr_population_hv
 * @property string $develop_mthd
 * @property string $access_to_sell
 * @property string $competitors
 * @property string $occupancy_use_dth
 * @property integer $id
 */
class LogCaParameterStatis extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'log_ca_parameter_statis';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['property_area_type', 'house_type', 'avr_occupancy_rate', 'myr_population_hv', 'develop_mthd', 'access_to_sell', 'competitors', 'occupancy_use_dth'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idlog' => 'Idlog',
            'property_area_type' => 'Property Area Type',
            'house_type' => 'House Type',
            'avr_occupancy_rate' => 'Avr Occupancy Rate',
            'myr_population_hv' => 'Myr Population Hv',
            'develop_mthd' => 'Develop Mthd',
            'access_to_sell' => 'Access To Sell',
            'competitors' => 'Competitors',
            'occupancy_use_dth' => 'Occupancy Use Dth',
            'id' => 'ID',
        ];
    }
}
