<?php

namespace app\models;

use Yii;
use common\models\StatusReference;
use yii\behaviors\TimestampBehavior; 
use yii\behaviors\BlameableBehavior;

class Subdistrict extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'subdistrict';
    }
	
	public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_date',
                'updatedAtAttribute' => 'updated_date',
                'value' => new \yii\db\Expression('NOW()'),
            ],            
            'blameable' => [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
            ],
        ];
    }

    public function rules()
    {
        return [
            [['id', 'name', 'id_district'], 'required'],
            [['id', 'id_district', 'zip_code'], 'integer'],
            [['name'], 'string', 'max' => 50],
            [['name', 'id_district'], 'unique', 'targetAttribute' => ['name', 'id_district'], 'message' => 'The combination of Name and Id District has already been taken.'],
            [['id_district'], 'exist', 'skipOnError' => true, 'targetClass' => District::className(), 'targetAttribute' => ['id_district' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'id_district' => 'Id District',
            'zip_code' => 'Zip Code',
        ];
    }

    public function getAreas()
    {
        return $this->hasMany(Area::className(), ['id_subdistrict' => 'id']);
    }

    public function getStreetnames()
    {
        return $this->hasMany(Streetname::className(), ['id_subdistrict' => 'id']);
    }

    public function getIdDistrict()
    {
        return $this->hasOne(District::className(), ['id' => 'id_district']);
    }
	
	public function getStatusReference()
	{
	return $this->hasOne(StatusReference::className(), ['id' => 'status_listing']);
	}
}
