<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "outbound_grf".
 *
 * @property integer $id_instruction_grf
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
 * @property string $note
 * @property string $plate_number
 * @property string $driver
 * @property string $revision_remark
 * @property string $print_time
 * @property string $handover_time
 * @property string $surat_jalan_number
 * @property string $incoming_date
 * @property string $created_date
 * @property string $updated_date
 * @property integer $id_modul
 * @property string $file_attachment_1
 * @property string $file_attachment_2
 * @property string $purpose
 * @property integer $requestor
 * @property integer $id_warehouse
 *
 * @property LogInstructionGrf[] $logInstructionGrves
 * @property Division $idDivision
 * @property InstructionGrf $idInstructionGrf
 * @property Labor $pic0
 * @property Modul $idModul
 * @property Reference $grfType
 * @property Reference $forwarder0
 * @property Region $idRegion
 * @property StatusReference $statusListing
 * @property User $createdBy
 * @property User $updatedBy
 * @property OutboundGrfDetail[] $outboundGrfDetails
 * @property TempOutboundGrfDetail[] $tempOutboundGrfDetails
 */

class OutboundGrf extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    // public $id;
    public static function tableName()
    {
        return 'outbound_grf';
    }

    /**
     * @inheritdoc
     */
    public $division,$file1,$file2, $name, $im_code, $brand, $sn_type, $id_outbound_grf,$grouping, $warna, $type, $description, $referenceSn, $qty_request, $id_item_im, $qty_detail, $id_detail, $id_outbound_grf_detail, $qty_return, $id_grf, $id, $orafin_code,  $requestor;
    public function rules()
    {
        return [
            // [['id_instruction_grf'], 'required'],
            [['id_instruction_grf','created_by', 'updated_by', 'status_listing', 'grf_type', 'id_division', 'id_region', 'pic', 'forwarder', 'id_modul', 'requestor', 'id_warehouse', 'status_return'], 'integer'],
            [['revision_remark', 'purpose'], 'string'],
            [['print_time', 'handover_time', 'incoming_date', 'created_date', 'updated_date'], 'safe'],
            [['grf_number'], 'string', 'max' => 50],
            [['wo_number', 'note', 'plate_number', 'driver', 'surat_jalan_number', 'file_attachment_1', 'file_attachment_2'], 'string', 'max' => 255],
            [['id_division'], 'exist', 'skipOnError' => true, 'targetClass' => Division::className(), 'targetAttribute' => ['id_division' => 'id']],
            [['id_instruction_grf'], 'exist', 'skipOnError' => true, 'targetClass' => InstructionGrf::className(), 'targetAttribute' => ['id_instruction_grf' => 'id']],
            [['pic'], 'exist', 'skipOnError' => true, 'targetClass' => Labor::className(), 'targetAttribute' => ['pic' => 'nik']],
            [['id_modul'], 'exist', 'skipOnError' => true, 'targetClass' => Modul::className(), 'targetAttribute' => ['id_modul' => 'id']],
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
            'id_instruction_grf' => 'Id Instruction Grf',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'status_listing' => 'Status Listing',
            'status_return' => 'Status Return',
            'grf_type' => 'Grf Type',
            'id_division' => 'Id Division',
            'id_region' => 'Id Region',
            'pic' => 'Pic',
            'forwarder' => 'Forwarder',
            'grf_number' => 'Grf Number',
            'wo_number' => 'Wo Number',
            'note' => 'Note',
            'plate_number' => 'Plate Number',
            'driver' => 'Driver',
            'revision_remark' => 'Revision Remark',
            'print_time' => 'Print Time',
            'handover_time' => 'Handover Time',
            'surat_jalan_number' => 'Surat Jalan Number',
            'incoming_date' => 'Incoming Date',
            'created_date' => 'Created Date',
            'updated_date' => 'Updated Date',
            'id_modul' => 'Id Modul',
            'file_attachment_1' => 'File Attachment 1',
            'file_attachment_2' => 'File Attachment 2',
            'purpose' => 'Purpose',
            'requestor' => 'Requestor',
            'id_warehouse' => 'Id Warehouse',
        ];
    }
   public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_date',
                'updatedAtAttribute' => 'updated_date',
                'value' => new \yii\db\Expression('NOW()'),
            ],
            'blameable' => [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
            ],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLogInstructionGrves()
    {
        return $this->hasMany(LogInstructionGrf::className(), ['id_outbound_grf' => 'id_instruction_grf']);
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
    public function getIdInstructionGrf()
    {
        return $this->hasOne(InstructionGrf::className(), ['id' => 'id_instruction_grf']);
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOutboundGrfDetails()
    {
        return $this->hasMany(OutboundGrfDetail::className(), ['id_outbound_grf' => 'id_instruction_grf']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTempOutboundGrfDetails()
    {
        return $this->hasMany(TempOutboundGrfDetail::className(), ['id_outbound_grf' => 'id_instruction_grf']);
    }

    public function getStatusReference()
    {
        return $this->hasOne(StatusReference::className(), ['id' => 'status_listing']);
    }

     public function getStatusReturn()
    {
        return $this->hasOne(StatusReference::className(), ['id' => 'status_return']);
    }
}
