<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "iko_team_wo_actual".
 *
 * @property string $nik
 * @property string $name
 * @property string $position
 * @property integer $id
 * @property integer $id_iko_wo_actual
 *
 * @property IkoWoActual $idIkoWoActual
 */
class IkoTeamWoActual extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'iko_team_wo_actual';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nik', 'id_iko_wo_actual'], 'required'],
            [['id_iko_wo_actual'], 'integer'],
            [['nik'], 'string', 'max' => 16],
            [['name', 'position'], 'string', 'max' => 50],
            [['id_iko_wo_actual'], 'exist', 'skipOnError' => true, 'targetClass' => IkoWoActual::className(), 'targetAttribute' => ['id_iko_wo_actual' => 'id_iko_wo']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'nik' => 'Nik',
            'name' => 'Name',
            'position' => 'Position',
            'id' => 'ID',
            'id_iko_wo_actual' => 'Id Iko Wo Actual',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdIkoWoActual()
    {
        return $this->hasOne(IkoWoActual::className(), ['id_iko_wo' => 'id_iko_wo_actual']);
    }
    public function getIdOsOutsourcePersonil()
    {
        return $this->hasOne(OsOutsourcePersonil::className(), ['employee_number' => 'nik']);
    }
}
