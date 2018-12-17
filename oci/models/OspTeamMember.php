<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use app\models\StatusReference;

class OspTeamMember extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'osp_team_member';
    }

    public function rules()
    {
        return [
            [['id_osp_team'], 'required'],
            [['id_osp_team'], 'integer'],
            [['created_date', 'updated_date'], 'safe'],
            [['revision_remark'], 'string'],
            [['nik'], 'string', 'max' => 16],
            [['name', 'position', 'created_by', 'updated_by'], 'string', 'max' => 50],
			[['id_osp_team', 'nik'], 'unique', 'targetAttribute' => ['id_osp_team', 'nik'], 'message' => 'The Person with this NIK has already added.'],
            [['id_osp_team'], 'exist', 'skipOnError' => true, 'targetClass' => OspTeam::className(), 'targetAttribute' => ['id_osp_team' => 'id']],
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
            'id_osp_team' => 'Id Osp Team',
            'nik' => 'NIK',
            'name' => 'Name',
            'position' => 'Position',
            'created_by' => 'Created By',
            'created_date' => 'Created Date',
            'updated_by' => 'Updated By',
            'updated_date' => 'Updated Date',
            'revision_remark' => 'Revision Remark',
        ];
    }

    public function getIdOspTeam()
    {
        return $this->hasOne(OspTeam::className(), ['id' => 'id_osp_team']);
    }

    public function getOspWoTeamMembers()
    {
        return $this->hasMany(OspWoTeamMember::className(), ['id_osp_team_wo' => 'id']);
    }
	
	public function getStatusReference()
    {
        return $this->hasOne(StatusReference::className(), ['id' => 'status_listing']);
    }
}
