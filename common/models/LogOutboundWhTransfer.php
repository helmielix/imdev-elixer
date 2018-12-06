<?php

namespace divisitiga\models;

use Yii;

/**
 * This is the model class for table "log_outbound_wh_transfer".
 *
 * @property int $idlog
 * @property int $id_instruction_wh
 * @property string $driver
 * @property int $created_by
 * @property int $updated_by
 * @property int $status_listing
 * @property int $forwarder
 * @property string $no_sj
 * @property string $plate_number
 * @property string $created_date
 * @property string $updated_date
 * @property string $revision_remark
 * @property int $id_modul
 *
 * @property InstructionWhTransfer $instructionWh
 * @property Modul $modul
 * @property OutboundWhTransfer $instructionWh0
 * @property Reference $forwarder0
 * @property StatusReference $statusListing
 * @property User $createdBy
 * @property User $updatedBy
 */
class LogOutboundWhTransfer extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'log_outbound_wh_transfer';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idlog'], 'required'],
            [['idlog', 'id_instruction_wh', 'created_by', 'updated_by', 'status_listing', 'forwarder', 'id_modul'], 'default', 'value' => null],
            [['idlog', 'id_instruction_wh', 'created_by', 'updated_by', 'status_listing', 'forwarder', 'id_modul'], 'integer'],
            [['created_date', 'updated_date'], 'safe'],
            [['revision_remark'], 'string'],
            [['driver'], 'string', 'max' => 50],
            [['no_sj', 'plate_number'], 'string', 'max' => 255],
            [['idlog'], 'unique'],
            [['id_instruction_wh'], 'exist', 'skipOnError' => true, 'targetClass' => InstructionWhTransfer::className(), 'targetAttribute' => ['id_instruction_wh' => 'id']],
            [['id_modul'], 'exist', 'skipOnError' => true, 'targetClass' => Modul::className(), 'targetAttribute' => ['id_modul' => 'id']],
            [['id_instruction_wh'], 'exist', 'skipOnError' => true, 'targetClass' => OutboundWhTransfer::className(), 'targetAttribute' => ['id_instruction_wh' => 'id_instruction_wh']],
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
            'idlog' => 'Idlog',
            'id_instruction_wh' => 'Id Instruction Wh',
            'driver' => 'Driver',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'status_listing' => 'Status Listing',
            'forwarder' => 'Forwarder',
            'no_sj' => 'No Sj',
            'plate_number' => 'Plate Number',
            'created_date' => 'Created Date',
            'updated_date' => 'Updated Date',
            'revision_remark' => 'Revision Remark',
            'id_modul' => 'Id Modul',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInstructionWh()
    {
        return $this->hasOne(InstructionWhTransfer::className(), ['id' => 'id_instruction_wh']);
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
    public function getInstructionWh0()
    {
        return $this->hasOne(OutboundWhTransfer::className(), ['id_instruction_wh' => 'id_instruction_wh']);
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
