<?php

namespace divisitiga\models;

use Yii;

/**
 * This is the model class for table "outbound_disposal".
 *
 * @property int $id_instruction_disposal
 * @property int $created_by
 * @property int $updated_by
 * @property int $status_listing
 * @property int $forwarder
 * @property string $driver
 * @property string $plat_number
 * @property string $created_date
 * @property string $updated_date
 * @property string $revision_remark
 *
 * @property StatusReference $statusListing
 * @property StatusReference $forwarder0
 * @property User $createdBy
 * @property User $updatedBy
 */
class OutboundDisposal extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'outbound_disposal';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_instruction_disposal', 'created_by', 'updated_by', 'forwarder', 'driver', 'plat_number', 'created_date'], 'required'],
            [['id_instruction_disposal', 'created_by', 'updated_by', 'status_listing', 'forwarder'], 'default', 'value' => null],
            [['id_instruction_disposal', 'created_by', 'updated_by', 'status_listing', 'forwarder'], 'integer'],
            [['created_date', 'updated_date'], 'safe'],
            [['revision_remark'], 'string'],
            [['driver', 'plat_number'], 'string', 'max' => 255],
            [['id_instruction_disposal'], 'unique'],
            [['status_listing'], 'exist', 'skipOnError' => true, 'targetClass' => StatusReference::className(), 'targetAttribute' => ['status_listing' => 'id']],
            [['forwarder'], 'exist', 'skipOnError' => true, 'targetClass' => StatusReference::className(), 'targetAttribute' => ['forwarder' => 'id']],
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
            'id_instruction_disposal' => 'Id Instruction Disposal',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'status_listing' => 'Status Listing',
            'forwarder' => 'Forwarder',
            'driver' => 'Driver',
            'plat_number' => 'Plat Number',
            'created_date' => 'Created Date',
            'updated_date' => 'Updated Date',
            'revision_remark' => 'Revision Remark',
        ];
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
    public function getForwarder0()
    {
        return $this->hasOne(StatusReference::className(), ['id' => 'forwarder']);
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
