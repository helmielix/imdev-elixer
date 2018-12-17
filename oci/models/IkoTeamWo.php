<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

class IkoTeamWo extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'iko_team_wo';
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
            [['id_iko_wo', 'nik'], 'required'],
            [['id_iko_wo', 'created_by', 'updated_by'], 'integer'],
            [['created_date', 'updated_date'], 'safe'],
            [['nik'], 'string', 'max' => 16],
            [['name', 'position'], 'string', 'max' => 50],
            [['created_by', 'updated_by'], 'integer'],
            [['id_iko_wo'], 'exist', 'skipOnError' => true, 'targetClass' => IkoWorkOrder::className(), 'targetAttribute' => ['id_iko_wo' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id_iko_wo' => 'Id Iko Wo',
            'nik' => 'Nik',
            'name' => 'Name',
            'position' => 'Position',
            'created_by' => 'Created By',
            'created_date' => 'Created Date',
            'updated_by' => 'Updated By',
            'updated_date' => 'Updated Date',
        ];
    }

    public function getIdIkoWo()
    {
        return $this->hasOne(IkoWorkOrder::className(), ['id' => 'id_iko_wo']);
    }

    public function getIdlabor()
    {
        return $this->hasOne(Labor::className(), ['nik' => 'nik']);
    }

	public function getIdIkoTeam()
    {
        return $this->hasOne(IkoTeam::className(), ['id_labor' => 'nik']);
    }

    public function getIkoTeamWoActual()
    {
        return $this->hasOne(IkoTeamWoActual::className(), ['id_iko_team_wo' => 'id_iko_wo']);
    }

	public function getStatusReference()
	{
	return $this->hasOne(StatusReference::className(), ['id' => 'status_listing']);
	}
}
