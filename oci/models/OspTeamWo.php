<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use app\models\StatusReference;

/**
 * This is the model class for table "osp_team_wo".
 *
 * @property integer $id
 * @property integer $id_osp_wo
 * @property string $leader
 * @property string $nik
 *
 * @property OspWorkOrder $idOspWo
 */
class OspTeamWo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'osp_team_wo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_osp_wo'], 'integer'],
            [['leader'], 'string', 'max' => 60],
            [['nik'], 'string', 'max' => 16],
			[['nik'], 'required'],
			// [['nik'], 'unique', 'targetAttribute' => ['nik'], 'message' => 'The Person with this NIK has already added to other team.'],
            [['id_osp_wo'], 'exist', 'skipOnError' => true, 'targetClass' => OspWorkOrder::className(), 'targetAttribute' => ['id_osp_wo' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_osp_wo' => 'Id Osp Wo',
            'leader' => 'Leader',
            'nik' => 'Nik',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdOspWo()
    {
        return $this->hasOne(OspWorkOrder::className(), ['id' => 'id_osp_wo']);
    }

	public function getIdOspTeam()
    {
        return $this->hasOne(OspTeam::className(), ['id_labor' => 'nik']);
    }

    public function getIdlabor()
    {
        return $this->hasOne(Labor::className(), ['nik' => 'nik']);
    }



	public function getStatusReference()
    {
        return $this->hasOne(StatusReference::className(), ['id' => 'status_listing']);
    }
}
