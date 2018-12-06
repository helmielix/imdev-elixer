<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "view_report_basurvey_province".
 *
 * @property string $province
 * @property integer $qtyhppotential_sum
 * @property integer $qtyhpsohopotential_sum
 */
class ViewReportBasurveyProvince extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'view_report_basurvey_province';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['qtyhppotential_sum', 'qtyhpsohopotential_sum'], 'integer'],
            [['province'], 'string', 'max' => 30],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'province' => 'Province',
            'qtyhppotential_sum' => 'Qtyhppotential Sum',
            'qtyhpsohopotential_sum' => 'Qtyhpsohopotential Sum',
        ];
    }
}
