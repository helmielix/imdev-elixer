<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "view_report_basurvey_subdistrict".
 *
 * @property string $subdistrict
 * @property integer $qtyhppotential_sum
 * @property integer $qtyhpsohopotential_sum
 */
class ViewReportBasurveySubdistrict extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'view_report_basurvey_subdistrict';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['qtyhppotential_sum', 'qtyhpsohopotential_sum'], 'integer'],
            [['subdistrict'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'subdistrict' => 'Subdistrict',
            'qtyhppotential_sum' => 'Qtyhppotential Sum',
            'qtyhpsohopotential_sum' => 'Qtyhpsohopotential Sum',
        ];
    }
}
