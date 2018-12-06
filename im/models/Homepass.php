<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "homepass".
 *
 * @property integer $id
 * @property string $status_ca
 * @property string $potency_type
 * @property string $iom_type
 * @property string $status_govrel
 * @property string $status_iko
 * @property string $home_number
 * @property string $hp_type
 * @property string $status
 * @property integer $id_ca_ba_survey
 * @property integer $id_govrel_ba_distribution
 * @property integer $id_iko_bas_plan
 * @property string $streetname
 * @property integer $kodepos
 * @property string $geom
 *
 * @property CaBaSurvey $idCaBaSurvey
 * @property GovrelBaDistribution $idGovrelBaDistribution
 * @property IkoBasPlan $idIkoBasPlan
 */
class Homepass extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'homepass';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_ca_ba_survey', 'id_govrel_ba_distribution', 'id_planning_iko_bas_plan', 'kodepos'], 'integer'],
            [['geom'], 'safe'],
            [['status_ca', 'status_govrel', 'status_iko', 'hp_type', 'status'], 'string', 'max' => 15],
            [['potency_type', 'iom_type'], 'string', 'max' => 20],
            [['home_number'], 'string', 'max' => 30],
            [['streetname'], 'string', 'max' => 255],
            [['id_ca_ba_survey'], 'exist', 'skipOnError' => true, 'targetClass' => CaBaSurvey::className(), 'targetAttribute' => ['id_ca_ba_survey' => 'id']],
            [['id_govrel_ba_distribution'], 'exist', 'skipOnError' => true, 'targetClass' => GovrelBaDistribution::className(), 'targetAttribute' => ['id_govrel_ba_distribution' => 'id']],
            [['id_planning_iko_bas_plan'], 'exist', 'skipOnError' => true, 'targetClass' => IkoBasPlan::className(), 'targetAttribute' => ['id_planning_iko_bas_plan' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'status_ca' => 'Status Ca',
            'potency_type' => 'Potency Type',
            'iom_type' => 'Iom Type',
            'status_govrel' => 'Status Govrel',
            'status_iko' => 'Status Iko',
            'home_number' => 'Home Number',
            'hp_type' => 'Hp Type',
            'status' => 'Status',
            'id_ca_ba_survey' => 'Id Ca Ba Survey',
            'id_govrel_ba_distribution' => 'Id Govrel Ba Distribution',
            'id_planning_iko_bas_plan' => 'Id Planning Iko Bas Plan',
            'streetname' => 'Streetname',
            'kodepos' => 'Kodepos',
            'geom' => 'Geom',
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
    public function getIdGovrelBaDistribution()
    {
        return $this->hasOne(GovrelBaDistribution::className(), ['id' => 'id_govrel_ba_distribution']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdIkoBasPlan()
    {
        return $this->hasOne(IkoBasPlan::className(), ['id' => 'id_iko_bas_plan']);
    }
}
