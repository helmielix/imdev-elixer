<?php

namespace divisitiga\models;

use Yii;

/**
 * This is the model class for table "log_inbound_grf".
 *
 * @property int $idlog
 * @property int $id
 * @property int $created_by
 * @property int $updated_by
 * @property int $status_listing
 * @property int $id_outbound_grf
 * @property string $incoming_date
 * @property string $created_date
 * @property string $updated_date
 *
 * @property OutboundGrf $outboundGrf
 * @property StatusReference $statusListing
 * @property User $createdBy
 * @property User $updatedBy
 */
class LogInboundGrf extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'log_inbound_grf';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idlog'], 'required'],
            [['idlog', 'created_by', 'updated_by', 'status_listing', 'id_outbound_grf'], 'default', 'value' => null],
            [['idlog', 'created_by', 'updated_by', 'status_listing', 'id_outbound_grf'], 'integer'],
            [['incoming_date', 'created_date', 'updated_date'], 'safe'],
            [['idlog'], 'unique'],
            [['id_outbound_grf'], 'exist', 'skipOnError' => true, 'targetClass' => OutboundGrf::className(), 'targetAttribute' => ['id_outbound_grf' => 'id']],
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
            'id' => 'ID',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'status_listing' => 'Status Listing',
            'id_outbound_grf' => 'Id Outbound Grf',
            'incoming_date' => 'Incoming Date',
            'created_date' => 'Created Date',
            'updated_date' => 'Updated Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOutboundGrf()
    {
        return $this->hasOne(OutboundGrf::className(), ['id' => 'id_outbound_grf']);
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
