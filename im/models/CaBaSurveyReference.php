<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ca_ba_survey_reference".
 *
 * @property integer $id
 * @property integer $id_ca_ba_survey
 * @property integer $id_ca_reference
 *
 * @property CaBaSurvey $idCaBaSurvey
 * @property CaReference $idCaReference
 */
class CaBaSurveyReference extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ca_ba_survey_reference';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_ca_ba_survey', 'id_ca_reference'], 'required'],
            [['id_ca_ba_survey', 'id_ca_reference'], 'integer'],
            [['id_ca_ba_survey'], 'exist', 'skipOnError' => true, 'targetClass' => CaBaSurvey::className(), 'targetAttribute' => ['id_ca_ba_survey' => 'id']],
            [['id_ca_reference'], 'exist', 'skipOnError' => true, 'targetClass' => CaReference::className(), 'targetAttribute' => ['id_ca_reference' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_ca_ba_survey' => 'Id Ca Ba Survey',
            'id_ca_reference' => 'Id Ca Reference',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdCaBaSurvey()
    {
        return $this->hasOne(CaBaSurvey::className(), ['id' => 'id_ca_ba_survey']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdCaReference()
    {
        return $this->hasOne(CaReference::className(), ['id' => 'id_ca_reference']);
    }
}
