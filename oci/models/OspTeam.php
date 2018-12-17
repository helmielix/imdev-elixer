<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior; 
use yii\behaviors\BlameableBehavior; 
use app\models\StatusReference;

class OspTeam extends \yii\db\ActiveRecord
{
	public $name;
    public static function tableName()
    {
        return 'osp_team';
    }

    public function rules()
    {
        return [
            [['id_labor'], 'required'],
            [['created_by', 'updated_by', 'wo_open', 'status_team'], 'integer'],
            [['created_date', 'updated_date'], 'safe'],
            [['revision_remark'], 'string'],
            [['leader', 'position'], 'string', 'max' => 50],
            [['id_labor'], 'string', 'max' => 16],
            [['id_labor'], 'exist', 'skipOnError' => true, 'targetClass' => Labor::className(), 'targetAttribute' => ['id_labor' => 'nik']],
            [['id_labor'], 'exist', 'skipOnError' => true, 'targetClass' => Labor::className(), 'targetAttribute' => ['id_labor' => 'nik']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_by' => 'id']],
        ];
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

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'leader' => 'Leader',
            'id_labor' => 'ID Labor',
            'created_by' => 'Created By',
            'created_date' => 'Created Date',
            'updated_by' => 'Updated By',
            'updated_date' => 'Updated Date',
            'revision_remark' => 'Revision Remark',
            'position' => 'Position',
            'wo_open' => 'Wo Open',
            'status_team' => 'Status Team',
        ];
    }

    public function getIdLabor()
    {
        return $this->hasOne(Labor::className(), ['nik' => 'id_labor']);
    }

    public function getIdLabor0()
    {
        return $this->hasOne(Labor::className(), ['nik' => 'id_labor']);
    }

    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    public function getUpdatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }

    public function getOspTeamMembers()
    {
        return $this->hasMany(OspTeamMember::className(), ['id_osp_team' => 'id']);
    }
	
	public function getStatusReference()
    {
        return $this->hasOne(StatusReference::className(), ['id' => 'status_team']);
    }
}
