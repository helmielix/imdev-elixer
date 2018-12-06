<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "district".
 *
 * @property integer $id
 * @property string $name
 * @property integer $id_city
 *
 * @property City $idCity
 * @property Subdistrict[] $subdistricts
 */
class District extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'district';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id','name', 'id_city'], 'required'],
            [['id','id_city'], 'integer'],
            [['name'], 'string', 'max' => 50],
            [['name', 'id_city'], 'unique', 'targetAttribute' => ['name', 'id_city'], 'message' => 'The combination of Name and Id City has already been taken.'],
            [['id_city'], 'exist', 'skipOnError' => true, 'targetClass' => City::className(), 'targetAttribute' => ['id_city' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID District',
            'name' => 'District',
            'id_city' => 'City',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdCity()
    {
        return $this->hasOne(City::className(), ['id' => 'id_city']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubdistricts()
    {
        return $this->hasMany(Subdistrict::className(), ['id_district' => 'id']);
    }
}
