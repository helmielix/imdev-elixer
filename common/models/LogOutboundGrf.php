<?php

namespace divisitiga\models;

use Yii;

/**
 * This is the model class for table "log_outbound_grf".
 *
 * @property integer $idlog
 * @property integer $id
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $status_listing
 * @property integer $grf_type
 * @property integer $id_division
 * @property integer $id_region
 * @property integer $pic
 * @property integer $forwarder
 * @property string $grf_number
 * @property string $wo_number
 * @property string $file
 * @property string $purpose
 * @property string $note
 * @property string $plate_number
 * @property string $driver
 * @property string $revision_remark
 * @property string $published_date
 * @property string $print_time
 * @property string $handover_time
 * @property string $surat_jalan_number
 * @property string $incoming_date
 * @property string $created_date
 * @property string $updated_date
 * @property integer $id_modul
 *
 * @property Division $idDivision
 * @property Labor $pic0
 * @property Modul $idModul
 * @property OutboundGrf $id0
 * @property Reference $grfType
 * @property Reference $forwarder0
 * @property Region $idRegion
 * @property StatusReference $statusListing
 * @property User $createdBy
 * @property User $updatedBy
 */
class LogOutboundGrf extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'log_outbound_grf';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idlog'], 'required'],
            [['idlog', 'created_by', 'updated_by', 'status_listing', 'grf_type', 'id_division', 'id_region', 'pic', 'forwarder', 'id_modul'], 'integer'],
            [['revision_remark'], 'string'],
            [['published_date', 'print_time', 'handover_time', 'incoming_date', 'created_date', 'updated_date'], 'safe'],
            [['grf_number'], 'string', 'max' => 50],
            [['wo_number', 'file', 'purpose', 'note', 'plate_number', 'driver', 'surat_jalan_number'], 'string', 'max' => 255],
            [['id_division'], 'exist', 'skipOnError' => true, 'targetClass' => Division::className(), 'targetAttribute' => ['id_division' => 'id']],
            [['pic'], 'exist', 'skipOnError' => true, 'targetClass' => Labor::className(), 'targetAttribute' => ['pic' => 'nik']],
            [['id_modul'], 'exist', 'skipOnError' => true, 'targetClass' => Modul::className(), 'targetAttribute' => ['id_modul' => 'id']],
            [['id'], 'exist', 'skipOnError' => true, 'targetClass' => OutboundGrf::className(), 'targetAttribute' => ['id' => 'id']],
            [['grf_type'], 'exist', 'skipOnError' => true, 'targetClass' => Reference::className(), 'targetAttribute' => ['grf_type' => 'id']],
            [['forwarder'], 'exist', 'skipOnError' => true, 'targetClass' => Reference::className(), 'targetAttribute' => ['forwarder' => 'id']],
            [['id_region'], 'exist', 'skipOnError' => true, 'targetClass' => Region::className(), 'targetAttribute' => ['id_region' => 'id']],
            [['status_listing'], 'exist', 'skipOnError' => true, 'targetClass' => StatusReference::className(), 'targetAttribute' => ['status_listing' => 'id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_by' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idlog' => 'Idlog',
            'id' => 'ID',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'status_listing' => 'Status Listing',
            'grf_type' => 'Grf Type',
            'id_division' => 'Id Division',
            'id_region' => 'Id Region',
            'pic' => 'Pic',
            'forwarder' => 'Forwarder',
            'grf_number' => 'Grf Number',
            'wo_number' => 'Wo Number',
            'file' => 'File',
            'purpose' => 'Purpose',
            'note' => 'Note',
            'plate_number' => 'Plate Number',
            'driver' => 'Driver',
            'revision_remark' => 'Revision Remark',
            'published_date' => 'Published Date',
            'print_time' => 'Print Time',
            'handover_time' => 'Handover Time',
            'surat_jalan_number' => 'Surat Jalan Number',
            'incoming_date' => 'Incoming Date',
            'created_date' => 'Created Date',
            'updated_date' => 'Updated Date',
            'id_modul' => 'Id Modul',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdDivision()
    {
        return $this->hasOne(Division::className(), ['id' => 'id_division']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPic0()
    {
        return $this->hasOne(Labor::className(), ['nik' => 'pic']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdModul()
    {
        return $this->hasOne(Modul::className(), ['id' => 'id_modul']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getId0()
    {
        return $this->hasOne(OutboundGrf::className(), ['id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGrfType()
    {
        return $this->hasOne(Reference::className(), ['id' => 'grf_type']);
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
    public function getIdRegion()
    {
        return $this->hasOne(Region::className(), ['id' => 'id_region']);
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
