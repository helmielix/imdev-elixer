<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "temp_ticket_trouble".
 *
 * @property integer $crm_id
 * @property string $crm_down_time
 * @property string $crm_customer_id
 * @property string $crm_subject
 * @property string $crm_last_status
 * @property string $crm_aging
 * @property string $crm_sla
 * @property string $crm_subcategory
 * @property string $crm_category
 * @property string $crm_no_fat
 * @property string $crm_city
 */
class TempTicketTrouble extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'temp_ticket_trouble';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['crm_id'], 'required'],
            [['crm_id'], 'integer'],
            // [['crm_down_time', 'crm_customer_id', 'crm_subject', 'crm_last_status', 'crm_aging', 'crm_sla', 'crm_subcategory', 'crm_category', 'crm_no_fat', 'crm_city'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'crm_id' => 'Crm ID',
            'crm_down_time' => 'Crm Down Time',
            'crm_customer_id' => 'Crm Customer ID',
            'crm_subject' => 'Crm Subject',
            'crm_last_status' => 'Crm Last Status',
            'crm_aging' => 'Crm Aging',
            'crm_sla' => 'Crm Sla',
            'crm_subcategory' => 'Crm Subcategory',
            'crm_category' => 'Crm Category',
            'crm_no_fat' => 'Crm No Fat',
            'crm_city' => 'Crm City',
        ];
    }
}
