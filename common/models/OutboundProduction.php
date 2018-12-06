<?php

namespace divisitiga\models;

use Yii;

/**
 * This is the model class for table "outbound_production".
 *
 * @property int $id_instruction_production
 * @property int $created_by
 * @property int $updated_by
 * @property int $forwarder
 * @property int $status_listing
 * @property string $created_date
 * @property string $updated_date
 * @property string $revision_remark
 * @property string $no_surat_jalan
 * @property string $plate_number
 * @property string $driver
 * @property string $file_attachment
 *
 * @property Reference $forwarder0
 * @property StatusReference $statusListing
 * @property User $createdBy
 * @property User $updatedBy
 */
class OutboundProduction extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'outbound_production';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_instruction_production', 'created_by', 'updated_by', 'forwarder', 'created_date', 'no_surat_jalan', 'plate_number'], 'required'],
            [['id_instruction_production', 'created_by', 'updated_by', 'forwarder', 'status_listing'], 'default', 'value' => null],
            [['id_instruction_production', 'created_by', 'updated_by', 'forwarder', 'status_listing'], 'integer'],
            [['created_date', 'updated_date'], 'safe'],
            [['revision_remark', 'plate_number'], 'string'],
            [['no_surat_jalan', 'driver', 'file_attachment'], 'string', 'max' => 255],
            [['id_instruction_production'], 'unique'],
            [['forwarder'], 'exist', 'skipOnError' => true, 'targetClass' => Reference::className(), 'targetAttribute' => ['forwarder' => 'id']],
            [['status_listing'], 'exist', 'skipOnError' => true, 'targetClass' => StatusReference::className(), 'targetAttribute' => ['status_listing' => 'id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_by' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_instruction_production' => 'Id Instruction Production',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'forwarder' => 'Forwarder',
            'status_listing' => 'Status Listing',
            'created_date' => 'Created Date',
            'updated_date' => 'Updated Date',
            'revision_remark' => 'Revision Remark',
            'no_surat_jalan' => 'No Surat Jalan',
            'plate_number' => 'Plate Number',
            'driver' => 'Driver',
            'file_attachment' => 'File Attachment',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getForwarder0()
    {
        return $this->hasOne(Reference::className(), ['id' => 'forwarder']);
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
}
