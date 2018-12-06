<?php

namespace divisitiga\models;

use Yii;

/**
 * This is the model class for table "log_outbound_production".
 *
 * @property int $idlog
 * @property int $id_instruction_production
 * @property int $created_by
 * @property int $updated_by
 * @property int $status_listing
 * @property int $forwarder
 * @property string $created_date
 * @property string $updated_date
 * @property string $revision_remark
 * @property string $no_surat_jalan
 * @property string $plate_number
 * @property string $driver
 * @property string $file_attachment
 *
 * @property Reference $statusListing
 * @property Reference $forwarder0
 * @property User $createdBy
 * @property User $updatedBy
 */
class LogOutboundProduction extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'log_outbound_production';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idlog'], 'required'],
            [['idlog', 'id_instruction_production', 'created_by', 'updated_by', 'status_listing', 'forwarder'], 'default', 'value' => null],
            [['idlog', 'id_instruction_production', 'created_by', 'updated_by', 'status_listing', 'forwarder'], 'integer'],
            [['created_date', 'updated_date'], 'safe'],
            [['revision_remark', 'plate_number'], 'string'],
            [['no_surat_jalan', 'driver', 'file_attachment'], 'string', 'max' => 255],
            [['idlog'], 'unique'],
            [['status_listing'], 'exist', 'skipOnError' => true, 'targetClass' => Reference::className(), 'targetAttribute' => ['status_listing' => 'id']],
            [['forwarder'], 'exist', 'skipOnError' => true, 'targetClass' => Reference::className(), 'targetAttribute' => ['forwarder' => 'id']],
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
            'idlog' => 'Idlog',
            'id_instruction_production' => 'Id Instruction Production',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'status_listing' => 'Status Listing',
            'forwarder' => 'Forwarder',
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
    public function getStatusListing()
    {
        return $this->hasOne(Reference::className(), ['id' => 'status_listing']);
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
