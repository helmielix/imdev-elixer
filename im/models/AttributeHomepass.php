<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "attribute_homepass".
 *
 * @property integer $id
 * @property string $status_ca
 * @property string $potency_type
 * @property string $iom_type
 * @property string $status_govrel
 * @property string $status_iko
 * @property string $home_number
 * @property string $hp_type
 * @property string $status
 * @property integer $id_ca_ba_survey
 * @property integer $id_govrel_ba_distribution
 * @property integer $id_iko_bas_plan
 * @property string $streetname
 * @property integer $kodepos
 * @property string $geom
 * @property string $region
 * @property string $city
 * @property string $district
 * @property string $subdistrict
 * @property string $id_area
 */
class AttributeHomepass extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'attribute_homepass';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_ca_ba_survey', 'id_govrel_ba_distribution', 'id_iko_bas_plan', 'kodepos'], 'integer'],
            [['geom'], 'string'],
            [['status_ca', 'status_govrel', 'status_iko', 'hp_type', 'status'], 'string', 'max' => 15],
            [['potency_type', 'iom_type', 'id_area'], 'string', 'max' => 20],
            [['home_number', 'region', 'city'], 'string', 'max' => 30],
            [['streetname'], 'string', 'max' => 255],
            [['district', 'subdistrict'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'status_ca' => 'Status Ca',
            'potency_type' => 'Potency Type',
            'iom_type' => 'Iom Type',
            'status_govrel' => 'Status Govrel',
            'status_iko' => 'Status Iko',
            'home_number' => 'Home Number',
            'hp_type' => 'Hp Type',
            'status' => 'Status',
            'id_ca_ba_survey' => 'Id Ca Ba Survey',
            'id_govrel_ba_distribution' => 'Id Govrel Ba Distribution',
            'id_iko_bas_plan' => 'Id Iko Bas Plan',
            'streetname' => 'Streetname',
            'kodepos' => 'Kodepos',
            'geom' => 'Geom',
            'region' => 'Region',
            'city' => 'City',
            'district' => 'District',
            'subdistrict' => 'Subdistrict',
            'id_area' => 'Id Area',
        ];
    }
}
