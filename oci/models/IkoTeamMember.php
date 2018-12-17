<?php

namespace app\models;

use Yii;
use app\models\StatusReference;
use yii\behaviors\TimestampBehavior; 
use yii\behaviors\BlameableBehavior;

class IkoTeamMember extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'iko_team_member';
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
            [['id', 'nik', 'id_iko_team'], 'integer'],
            [['name'], 'string', 'max' => 50],
            [['id'], 'unique'],
            [['nik'], 'required'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_iko_team' => 'Team ID',
            'name' => 'Labor Name',
            'nik' => 'NIK',        ];
    }

    public function getTeam()
    {
        return $this->hasMany(IkoTeam::className(), ['id' => 'id_labor']);
    }
	
	public function getStatusReference()
	{
	return $this->hasOne(StatusReference::className(), ['id' => 'status_listing']);
	}
}
