<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "log_ca_parameter_survey".
 *
 * @property integer $idlog
 * @property integer $id
 * @property integer $id_ca_parameter
 * @property integer $id_ca_ba_survey
 */
class LogCaParameterSurvey extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'log_ca_parameter_survey';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_ca_parameter', 'id_ca_ba_survey'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idlog' => 'Idlog',
            'id' => 'ID',
            'id_ca_parameter' => 'Id Ca Parameter',
            'id_ca_ba_survey' => 'Id Ca Ba Survey',
        ];
    }
}
