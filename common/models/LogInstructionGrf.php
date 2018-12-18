<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "log_instruction_grf".
 *
 * @property integer $id
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $status_listing
 * @property string $incoming_date
 * @property string $created_date
 * @property string $updated_date
 * @property string $note
 * @property integer $id_modul
 * @property integer $id_grf
 * @property integer $id_warehouse
 * @property string $date_of_return
 * @property integer $status_return
 * @property string $revision_remark
 */
class LogInstructionGrf extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $grf_type, $grf_number, $wo_number, $file_attachment_1, $file_attachment_2, $file_attachment_3, $purpose, $id_region, $id_division, $requestor, $pic,$division, $file1, $file2, $orafin_code, $qty_request, $wh_origin, $team_leader, $team_name, $grf_input, $grf_verify, $grf_approve;
    
    public static function tableName()
    {
        return 'log_instruction_grf';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_by', 'updated_by', 'status_listing', 'id_modul', 'id_grf', 'id_warehouse', 'status_return'], 'integer'],
            [['incoming_date', 'created_date', 'updated_date', 'date_of_return', 'idlog', 'id'], 'safe'],
            [['note', 'revision_remark'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'idlog' => 'ID',
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
            'id_warehouse' => 'Warehouse',
        ];
    }

    public function getIdGrf()
    {
        return $this->hasOne(Grf::className(), ['id' => 'id']);
    }

    public function getIdWarehouse()
    {
        return $this->hasOne(Warehouse::className(), ['id' => 'id_warehouse']);
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
        return $this->hasMany(InstructionGrfDetail::className(), ['id_instruction_grf' => 'id']);
    }
}
