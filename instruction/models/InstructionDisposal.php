<?php

namespace instruction\models;

use Yii;

/**
 * This is the model class for table "instruction_disposal".
 *
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $status_listing
 * @property integer $no_iom
 * @property integer $warehouse
 * @property integer $buyer
 * @property string $created_date
 * @property string $updated_date
 * @property string $target_implementation
 * @property string $revision_remark
 * @property integer $id
 */
class InstructionDisposal extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'instruction_disposal';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_by', 'no_iom', 'warehouse', 'buyer', 'created_date', 'target_implementation'], 'required'],
            [['created_by', 'updated_by', 'status_listing', 'no_iom', 'warehouse', 'buyer'], 'integer'],
            [['created_date', 'updated_date', 'target_implementation'], 'safe'],
            [['revision_remark'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'status_listing' => 'Status Listing',
            'no_iom' => 'No Iom',
            'warehouse' => 'Warehouse',
            'buyer' => 'Buyer',
            'created_date' => 'Created Date',
            'updated_date' => 'Updated Date',
            'target_implementation' => 'Target Implementation',
            'revision_remark' => 'Revision Remark',
            'id' => 'ID',
        ];
    }
}
