<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "osp_team_wo_actual".
 *
 * @property integer $id
 * @property integer $id_osp_wo_actual
 * @property string $name
 * @property string $nik
 * @property string $position
 *
 * @property OspWoActual $idOspWoActual
 */
class OspTeamWoActual extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'osp_team_wo_actual';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_osp_wo_actual'], 'required'],
            [['id_osp_wo_actual'], 'integer'],
            [['name'], 'string', 'max' => 60],
            [['nik'], 'string', 'max' => 16],
            [['position'], 'string', 'max' => 50],
            [['id_osp_wo_actual'], 'exist', 'skipOnError' => true, 'targetClass' => OspWoActual::className(), 'targetAttribute' => ['id_osp_wo_actual' => 'id_osp_wo']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_osp_wo_actual' => 'Id Osp Wo Actual',
            'name' => 'Name',
            'nik' => 'Nik',
            'position' => 'Position',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdOspWoActual()
    {
        return $this->hasOne(OspWoActual::className(), ['id_osp_wo' => 'id_osp_wo_actual']);
    }
    public function getIdOsOutsourcePersonil()
    {
        return $this->hasOne(OsOutsourcePersonil::className(), ['employee_number' => 'nik']);
    }
}
