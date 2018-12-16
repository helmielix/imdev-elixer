<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "log_instruction_grf".
 *
 * @property integer $id
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $status_listing
 * @property string $incoming_date
 * @property string $created_date
 * @property string $updated_date
 * @property string $note
 * @property integer $id_modul
 * @property integer $id_grf
 * @property integer $id_warehouse
 * @property string $date_of_return
 * @property integer $status_return
 * @property string $revision_remark
 */
class LogInstructionGrf extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'log_instruction_grf';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_by', 'updated_by', 'status_listing', 'id_modul', 'id_grf', 'id_warehouse', 'status_return'], 'integer'],
            [['incoming_date', 'created_date', 'updated_date', 'date_of_return'], 'safe'],
            [['note', 'revision_remark'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'status_listing' => 'Status Listing',
            'incoming_date' => 'Incoming Date',
            'created_date' => 'Created Date',
            'updated_date' => 'Updated Date',
            'note' => 'Note',
            'id_modul' => 'Id Modul',
            'id_grf' => 'Id Grf',
            'id_warehouse' => 'Id Warehouse',
            'date_of_return' => 'Date Of Return',
            'status_return' => 'Status Return',
            'revision_remark' => 'Revision Remark',
        ];
    }
}
