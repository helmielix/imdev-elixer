<?php

namespace app\models;

use Yii;
use common\models\StatusReference;
use yii\behaviors\TimestampBehavior; 
use yii\behaviors\BlameableBehavior;

class Labor extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'labor';
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
            [['nik'], 'required'],
            [['nik'], 'string', 'max' => 16],
            [['name', 'position'], 'string', 'max' => 50],
        ];
    }

    public function attributeLabels()
    {
        return [
            'nik' => 'Nik',
            'name' => 'Name',
            'position' => 'Position',
        ];
    }

    public function getIkoTeams()
    {
        return $this->hasMany(IkoTeam::className(), ['id_labor' => 'nik']);
    }

    public function getOspTeams()
    {
        return $this->hasMany(OspTeam::className(), ['id_labor' => 'nik']);
    }
	
	public function getStatusReference()
	{
	return $this->hasOne(StatusReference::className(), ['id' => 'status_listing']);
	}
}
