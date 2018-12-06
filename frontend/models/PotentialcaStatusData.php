<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "potentialca_status_data".
 *
 * @property string $status
 * @property string $total_input
 * @property string $total_verifikasi
 * @property string $total_approve
 */
class PotentialcaStatusData extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'potentialca_status_data';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status'], 'string'],
            [['total_input', 'total_verifikasi', 'total_approve'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'status' => 'Status',
            'total_input' => 'Total Input',
            'total_verifikasi' => 'Total Verifikasi',
            'total_approve' => 'Total Approve',
        ];
    }
}
