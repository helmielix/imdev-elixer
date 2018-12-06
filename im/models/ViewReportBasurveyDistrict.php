<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "view_report_basurvey_district".
 *
 * @property string $district
 * @property integer $qtyhppotential_sum
 * @property integer $qtyhpsohopotential_sum
 */
class ViewReportBasurveyDistrict extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'view_report_basurvey_district';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['qtyhppotential_sum', 'qtyhpsohopotential_sum'], 'integer'],
            [['district'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'district' => 'District',
            'qtyhppotential_sum' => 'Qtyhppotential Sum',
            'qtyhpsohopotential_sum' => 'Qtyhpsohopotential Sum',
        ];
    }
}
