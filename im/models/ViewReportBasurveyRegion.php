<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "view_report_basurvey_region".
 *
 * @property string $region
 * @property integer $qtyhppotential_sum
 * @property integer $qtyhpsohopotential_sum
 */
class ViewReportBasurveyRegion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'view_report_basurvey_region';
    }

	public static function primaryKey()
     {
          return array('region');
     }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['qtyhppotential_sum', 'qtyhpsohopotential_sum'], 'integer'],
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
            'qtyhppotential_sum' => 'Qtyhppotential Sum',
            'qtyhpsohopotential_sum' => 'Qtyhpsohopotential Sum',
        ];
    }
}
