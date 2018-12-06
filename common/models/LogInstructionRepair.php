<?php

namespace divisitiga\models;

use Yii;

/**
 * This is the model class for table "log_instruction_repair".
 *
 * @property int $idlog
 * @property int $id
 * @property int $created_by
 * @property int $updated_by
 * @property int $id_warehouse
 * @property int $status_listing
 * @property string $target_pengiriman
 * @property string $file_attachment
 * @property string $revision_remark
 * @property string $created_date
 * @property string $updated_date
 * @property int $id_modul
 * @property string $instruction_number
 * @property int $qty
 * @property int $vendor_repair
 * @property string $note
 *
 * @property Modul $modul
 * @property StatusReference $statusListing
 * @property User $createdBy
 * @property User $updatedBy
 * @property Warehouse $warehouse
 */
class LogInstructionRepair extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'log_instruction_repair';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idlog'], 'required'],
            [['idlog', 'id', 'created_by', 'updated_by', 'id_warehouse', 'status_listing', 'id_modul', 'qty', 'vendor_repair'], 'default', 'value' => null],
            [['idlog', 'id', 'created_by', 'updated_by', 'id_warehouse', 'status_listing', 'id_modul', 'qty', 'vendor_repair'], 'integer'],
            [['target_pengiriman', 'created_date', 'updated_date'], 'safe'],
            [['file_attachment', 'revision_remark', 'note'], 'string'],
            [['instruction_number'], 'string', 'max' => 255],
            [['idlog'], 'unique'],
            [['id_modul'], 'exist', 'skipOnError' => true, 'targetClass' => Modul::className(), 'targetAttribute' => ['id_modul' => 'id']],
            [['status_listing'], 'exist', 'skipOnError' => true, 'targetClass' => StatusReference::className(), 'targetAttribute' => ['status_listing' => 'id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_by' => 'id']],
            [['id_warehouse'], 'exist', 'skipOnError' => true, 'targetClass' => Warehouse::className(), 'targetAttribute' => ['id_warehouse' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idlog' => 'Idlog',
            'id' => 'ID',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'id_warehouse' => 'Id Warehouse',
            'status_listing' => 'Status Listing',
            'target_pengiriman' => 'Target Pengiriman',
            'file_attachment' => 'File Attachment',
            'revision_remark' => 'Revision Remark',
            'created_date' => 'Created Date',
            'updated_date' => 'Updated Date',
            'id_modul' => 'Id Modul',
            'instruction_number' => 'Instruction Number',
            'qty' => 'Qty',
            'vendor_repair' => 'Vendor Repair',
            'note' => 'Note',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getModul()
    {
        return $this->hasOne(Modul::className(), ['id' => 'id_modul']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatusListing()
    {
        return $this->hasOne(StatusReference::className(), ['id' => 'status_listing']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWarehouse()
    {
        return $this->hasOne(Warehouse::className(), ['id' => 'id_warehouse']);
    }
}
