<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "subdistrict".
 *
 * @property integer $id
 * @property string $name
 * @property integer $id_district
 * @property integer $zip_code
 *
 * @property STREETNAME[] $sTREETNAMEs
 * @property Area[] $areas
 * @property District $idDistrict
 */
class Subdistrict extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'subdistrict';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'name', 'id_district'], 'required'],
            [['id', 'id_district', 'zip_code'], 'integer'],
            [['name'], 'string', 'max' => 50],
			[['zip_code'], 'unique'],
            [['name', 'id_district'], 'unique', 'targetAttribute' => ['name', 'id_district'], 'message' => 'The combination of Name and Id District has already been taken.'],
            [['id_district'], 'exist', 'skipOnError' => true, 'targetClass' => District::className(), 'targetAttribute' => ['id_district' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID Subdistrict',
            'name' => 'Subdistrict',
            'id_district' => 'District',
            'zip_code' => 'Zip Code',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStreetnames()
    {
        return $this->hasMany(Streetname::className(), ['id_subdistrict' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAreas()
    {
        return $this->hasMany(Area::className(), ['id_subdistrict' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdDistrict()
    {
        return $this->hasOne(District::className(), ['id' => 'id_district']);
    }
}
