<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "dash_ca_iom_status".
 *
 * @property string $region
 * @property integer $year_survey
 * @property integer $month_survey
 * @property integer $approved
 * @property integer $inputted
 * @property integer $rejected
 */
class DashCaIomStatus extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dash_ca_iom_status';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['year_survey', 'month_survey', 'approved', 'inputted', 'rejected'], 'integer'],
            [['region'], 'string', 'max' => 30],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'region' => 'Region',
            'year_survey' => 'Year Survey',
            'month_survey' => 'Month Survey',
            'approved' => 'Approved',
            'inputted' => 'Inputted',
            'rejected' => 'Rejected',
        ];
    }
}
