<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "view_report_basurvey_area".
 *
 * @property string $area
 * @property integer $qtyhppotential_sum
 * @property integer $qtyhpsohopotential_sum
 */
class ViewReportBasurveyArea extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'view_report_basurvey_area';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['qtyhppotential_sum', 'qtyhpsohopotential_sum'], 'integer'],
            [['area'], 'string', 'max' => 35],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'area' => 'Area',
            'qtyhppotential_sum' => 'Qtyhppotential Sum',
            'qtyhpsohopotential_sum' => 'Qtyhpsohopotential Sum',
        ];
    }
}
