<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "view_area".
 *
 * @property string $id_area
 * @property integer $homepass
 * @property string $subdistrict
 * @property string $district
 * @property string $city
 * @property string $province
 * @property string $region
 * @property string $geom
 */
class ViewArea extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'view_area';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['homepass'], 'integer'],
            [['geom'], 'string'],
            [['id_area'], 'string', 'max' => 20],
            [['subdistrict', 'district'], 'string', 'max' => 50],
            [['city', 'province', 'region'], 'string', 'max' => 30],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_area' => 'Id Area',
            'homepass' => 'Homepass',
            'subdistrict' => 'Subdistrict',
            'district' => 'District',
            'city' => 'City',
            'province' => 'Province',
            'region' => 'Region',
            'geom' => 'Geom',
        ];
    }
}
