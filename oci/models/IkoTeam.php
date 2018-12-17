<?php

namespace app\models;

use Yii;
// use common\models\StatusReference;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

class IkoTeam extends \yii\db\ActiveRecord
{
    public $name;
    public static function tableName()
    {
        return 'iko_team';
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
            [['id', 'id_labor','status_team'], 'integer'],
            [['leader'], 'string', 'max' => 50],
            [['id'], 'unique'],
            [['id_labor'], 'required'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'leader' => 'Name',
            'id_labor' => 'ID Labor',
            'status_team' => 'Status Team',    ];
    }

    public function getLabor()
    {
        return $this->hasMany(Labor::className(), ['nik' => 'id_labor']);
    }

	public function getStatusReference()
	{
	return $this->hasOne(StatusReference::className(), ['id' => 'status_listing']);
	}

    public function getIkoTeamMembers()
    {
        return $this->hasMany(IkoTeamMember::className(), ['id_iko_team' => 'id']);
    }
}
