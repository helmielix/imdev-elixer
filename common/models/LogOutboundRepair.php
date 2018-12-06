<?php

namespace divisitiga\models;

use Yii;

/**
 * This is the model class for table "log_outbound_repair".
 *
 * @property int $idlog
 * @property int $id_instruction_repair
 * @property int $created_by
 * @property int $updated_by
 * @property int $status_listing
 * @property string $driver
 * @property int $forwarder
 * @property string $no_sj
 * @property string $plate_number
 * @property string $created_date
 * @property string $updated_date
 * @property string $revision_remark
 * @property int $id_modul
 *
 * @property InstructionRepair $instructionRepair
 * @property Modul $modul
 * @property Reference $forwarder0
 * @property StatusReference $statusListing
 * @property User $createdBy
 * @property User $updatedBy
 */
class LogOutboundRepair extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'log_outbound_repair';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idlog'], 'required'],
            [['idlog', 'id_instruction_repair', 'created_by', 'updated_by', 'status_listing', 'forwarder', 'id_modul'], 'default', 'value' => null],
            [['idlog', 'id_instruction_repair', 'created_by', 'updated_by', 'status_listing', 'forwarder', 'id_modul'], 'integer'],
            [['created_date', 'updated_date'], 'safe'],
            [['revision_remark'], 'string'],
            [['driver'], 'string', 'max' => 50],
            [['no_sj', 'plate_number'], 'string', 'max' => 255],
            [['idlog'], 'unique'],
            [['id_instruction_repair'], 'exist', 'skipOnError' => true, 'targetClass' => InstructionRepair::className(), 'targetAttribute' => ['id_instruction_repair' => 'id']],
            [['id_modul'], 'exist', 'skipOnError' => true, 'targetClass' => Modul::className(), 'targetAttribute' => ['id_modul' => 'id']],
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
            'id_instruction_repair' => 'Id Instruction Repair',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'status_listing' => 'Status Listing',
            'driver' => 'Driver',
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
    public function getInstructionRepair()
    {
        return $this->hasOne(InstructionRepair::className(), ['id' => 'id_instruction_repair']);
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
