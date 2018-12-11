<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use common\models\Division;
use common\models\Vendor;

/**
 * This is the model class for table "grf".
 *
 * @property integer $id
 * @property string $grf_number
 * @property string $wo_number
 * @property integer $grf_type
 * @property integer $requestor
 * @property string $file_attachment_1
 * @property string $file_attachment_2
 * @property string $purpose
 * @property integer $created_by
 * @property string $created_date
 * @property integer $updated_by
 * @property string $updated_date
 * @property integer $status_listing
 * @property integer $pic
 * @property integer $region
 * @property integer $id_division
 *
 * @property Labor $pic0
 * @property Reference $grfType
 * @property Reference $requestor0
 * @property Region $region0
 */
class Grf extends \yii\db\ActiveRecord
{
    public $file1,$file2,$file3, $division;
    public   $rr_date,  $item_name, $im_code, $grouping, $qty, $sn_type, $id_instruction_grf, $orafin_code, $orafin_name, $id_detail, $id_instruction, $id_instruction_detail, $brand, $warna, $qty_good, $qty_not_good, $qty_reject, $incoming_date, $team_leader, $team_name, $verified_by;

    public static function tableName()
    {
        return 'grf';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[ 'grf_type', 'status_listing', 'pic', 'id_region', 'id_division', 'status_return', 'id_vendor','requestor', 'team_leader', 'team_name'], 'integer'],
            [['purpose'], 'string'],
            [['grf_type_des','date_of_return'], 'safe'],
            [['grf_number', 'wo_number', 'file_attachment_1', 'file_attachment_2', 'file_attachment_3'], 'string', 'max' => 255],
            [['pic'], 'exist', 'skipOnError' => true, 'targetClass' => Labor::className(), 'targetAttribute' => ['pic' => 'nik']],
            [['grf_type'], 'exist', 'skipOnError' => true, 'targetClass' => Reference::className(), 'targetAttribute' => ['grf_type' => 'id']],
            [['requestor'], 'exist', 'skipOnError' => true, 'targetClass' => Reference::className(), 'targetAttribute' => ['requestor' => 'id']],
            [['id_region'], 'exist', 'skipOnError' => true, 'targetClass' => Region::className(), 'targetAttribute' => ['id_region' => 'id']],
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
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
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
            'status_listing' => 'Status Listing',
            'status_return' => 'Status Return',
            'pic' => 'Pic',
            'id_region' => 'Region',
            'id_division' => 'Division',
            'file1' => 'File Attachment 1',
            'file2' => 'File Attachment 2',
            'file3' => 'File Attachment 3',
            'id_vendor' => 'Vendor',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPicName()
    {
        return $this->hasOne(Labor::className(), ['nik' => 'pic']);
    }

    public function getTeamLeader()
    {
        return $this->hasOne(Labor::className(), ['nik' => 'team_leader']);
    }

    public function getTeamName()
    {
        return $this->hasOne(Reference::className(), ['id' => 'team_name']);
    }

    public function getIdDivision()
    {
        return $this->hasOne(Division::className(), ['id' => 'id_division']);
    }

    public function getIdVendor()
    {
        return $this->hasOne(Vendor::className(), ['id' => 'id_vendor']);
    }

    public function getIdRegion()
    {
        return $this->hasOne(Region::className(), ['id' => 'id_region']);
    }

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
    public function getGrfType()
    {
        return $this->hasOne(Reference::className(), ['id' => 'grf_type']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRequestorName()
    {
        return $this->hasOne(Reference::className(), ['id' => 'requestor']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRegion0()
    {
        return $this->hasOne(Region::className(), ['id' => 'id_region']);
    }
    public function getIdGrfDetail()
    {
        return $this->hasOne(GrfDetail::className(), ['id_grf' => 'id']);
    }
     public function getIdWarehouse()
    {
        return $this->hasOne(Warehouse::className(), ['id' => 'id_warehouse']);
    }
    public function getInstructionGrfDetails()
    {
        return $this->hasMany(InstructionGrfDetail::className(), ['id_instruction_grf' => 'id']);
    }
    public function getOrafinPrToPay()
    {
        return $this->hasMany(OrafinViewMkmPrToPay::className(), ['rcv_no' => 'rr_number', 'po_num' => 'po_number']);
    }
    public function getIdInGrf()
    {
        return $this->hasMany(InstructionGrf::className(), ['id' => 'id']);
    }

    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    public function getVerifiedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'verified_by']);
    }

    public function getApprovedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'approved_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }
}
