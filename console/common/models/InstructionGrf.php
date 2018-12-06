<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "inbound_grf".
 *
 * @property integer $id
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $status_listing
 * @property string $incoming_date
 * @property string $created_date
 * @property string $updated_date
 * @property string $note
 *
 * @property Grf $id0
 * @property StatusReference $statusListing
 * @property User $createdBy
 * @property User $updatedBy
 * @property InboundGrfDetail[] $inboundGrfDetails
 */
class InstructionGrf extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $grf_type, $grf_number, $wo_number, $file_attachment_1, $file_attachment_2, $file_attachment_3, $purpose, $id_region, $id_division, $requestor, $pic,$division, $file1, $file2, $orafin_code, $qty_request, $wh_origin;
    public static function tableName()
    {
        return 'instruction_grf';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // [['created_by', 'created_date']],
            [['created_by', 'updated_by', 'status_listing', 'status_return'], 'integer'],
            [['incoming_date', 'created_date', 'updated_date','date_of_return'], 'safe'],
            [['note'], 'string'],
            [['id'], 'exist', 'skipOnError' => true, 'targetClass' => Grf::className(), 'targetAttribute' => ['id' => 'id']],
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
            'id' => 'ID',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'status_listing' => 'Status Listing',
            'incoming_date' => 'Target Kirim',
            'date_of_return'=> 'Tanggal Pengembalian',
            'created_date' => 'Created Date',
            'updated_date' => 'Updated Date',
            'note' => 'Note',
            'grf_number' => 'Nomor GRF',
            'wo_number' => 'No WO/IOM',
            'grf_type' => 'Tipe GRF',
            'requestor' => 'Requestor',
            'file_attachment_1' => 'File Attachment 1',
            'file_attachment_2' => 'File Attachment 2',
            'file_attachment_3' => 'File Attachment 3',
            'purpose' => 'Purpose',
            'created_by' => 'Created By',
            'created_date' => 'Created Date',
            'updated_by' => 'Updated By',
            'updated_date' => 'Updated Date',
            'status_return' => 'Status Return',
            'pic' => 'Pic',
            'id_region' => 'Region',
            'id_division' => 'Division',
            'file1' => 'File Attachment 1',
            'file2' => 'File Attachment 2',
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
    public function getIdGrf()
    {
        return $this->hasOne(Grf::className(), ['id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatusReference()
    {
        return $this->hasOne(StatusReference::className(), ['id' => 'status_listing']);
    }

    public function getStatusReturn()
    {
        return $this->hasOne(StatusReference::className(), ['id' => 'status_return']);
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
    public function getGrfType()
    {
        return $this->hasOne(Reference::className(), ['id' => 'grf_type']);
    }
    public function getRequestorName()
    {
        return $this->hasOne(Reference::className(), ['id' => 'requestor']);
    }
    public function getIdDivision()
    {
        return $this->hasOne(Division::className(), ['id' => 'id_division']);
    }
     public function getIdRegion()
    {
        return $this->hasOne(Region::className(), ['id' => 'id_region']);
    }
     public function getPicName()
    {
        return $this->hasOne(Labor::className(), ['nik' => 'pic']);
    }
     public function getIdInstructionGrfDetail()
    {
        return $this->hasOne(InstructionGrfDetail::className(), ['id_instruction_grf' => 'id']);
    }



    // public function getIdInboundGrfDetail()
    // {
    //     return $this->hasOne(InboundGrfDetail::className(), ['id_instruction_grf' => 'id']);
    // }

    /**
     * @return \yii\db\ActiveQuery
     */
}
