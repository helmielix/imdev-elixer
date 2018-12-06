<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "mkm_master_item".
 *
 * @property string $item_code
 * @property string $item_desc
 * @property string $item_uom_code
 * @property string $item_uom_desc
 * @property integer $location_id
 * @property string $location_code
 * @property string $location
 * @property integer $organization_id
 * @property string $source_code
 * @property integer $distribution_account_id
 * @property integer $transaction_cost
 * @property integer $prior_cost
 * @property integer $new_cost
 * @property integer $expense_account
 * @property string $segment1
 * @property string $segment2
 * @property string $segment3
 * @property string $segment4
 * @property string $segment5
 * @property string $segment6
 */
class MkmMasterItem extends \yii\db\ActiveRecord
{
    public $qty_request;
    public static function tableName()
    {
        return 'mkm_master_item';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['item_code', 'item_desc', 'item_uom_code', 'item_uom_desc', 'location_id', 'location_code', 'location', 'organization_id', 'expense_account', 'segment1', 'segment2', 'segment3', 'segment4', 'segment5', 'segment6'], 'required'],
            [['location_id', 'organization_id', 'distribution_account_id', 'transaction_cost', 'prior_cost', 'new_cost', 'expense_account'], 'integer'],
            [['item_code'], 'string', 'max' => 40],
            [['item_desc', 'location'], 'string', 'max' => 240],
            [['item_uom_code'], 'string', 'max' => 3],
            [['item_uom_desc', 'segment1', 'segment2', 'segment3', 'segment4', 'segment5', 'segment6'], 'string', 'max' => 25],
            [['location_code'], 'string', 'max' => 60],
            [['source_code'], 'string', 'max' => 30],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'item_code' => 'Item Code',
            'item_desc' => 'Item Desc',
            'item_uom_code' => 'Item Uom Code',
            'item_uom_desc' => 'Item Uom Desc',
            'location_id' => 'Location ID',
            'location_code' => 'Location Code',
            'location' => 'Location',
            'organization_id' => 'Organization ID',
            'source_code' => 'Source Code',
            'distribution_account_id' => 'Distribution Account ID',
            'transaction_cost' => 'Transaction Cost',
            'prior_cost' => 'Prior Cost',
            'new_cost' => 'New Cost',
            'expense_account' => 'Expense Account',
            'segment1' => 'Segment1',
            'segment2' => 'Segment2',
            'segment3' => 'Segment3',
            'segment4' => 'Segment4',
            'segment5' => 'Segment5',
            'segment6' => 'Segment6',
        ];
    }
}
