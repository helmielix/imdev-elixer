<?php

namespace common\models;

use Yii;
use common\models\StatusReference;
use common\models\User;
use common\models\OrafinRr;
use common\models\OrafinViewMkmPrToPay;

use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
/**
 * This is the model class for table "inbound_po".
 *
 * @property integer $id
 * @property integer $rr_number
 * @property integer $created_by
 * @property integer $updated_by
 * @property string $created_date
 * @property string $updated_date
 * @property integer $status_listing
 *
 * @property StatusReference $statusListing
 * @property User $createdBy
 * @property User $updatedBy
 * @property InboundPoDetail[] $inboundPoDetails
 */
class InboundPo extends \yii\db\ActiveRecord
{
    public   $rr_date,  $item_name, $im_code, $grouping, $qty, $sn_type, $id_inbound_po, $orafin_code, $orafin_name, $id_detail, $id_inbound, $id_inbound_detail, $brand, $warna, $qty_good, $qty_not_good, $qty_reject, $id_item_im, $type, $req_good_qty, $qty_rr, $file;
	
    public static function tableName()
    {
        return 'inbound_po';
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
    public function rules()
    {
        return [
            [[ 'po_number', 'rr_number', 'tgl_sj', 'no_sj', 'id_warehouse'], 'required'],
            [[ 'file'], 'required', 'on' => 'create'],
            [[ 'created_by', 'updated_by', 'status_listing','verified_by','approved_by'], 'integer'],
            [['created_date', 'updated_date'], 'safe'],
            [['file'], 'file', 'extensions' => 'pdf,jpg', 'maxSize'=>1024*1024*5],
            [['status_listing'], 'exist', 'skipOnError' => true, 'targetClass' => StatusReference::className(), 'targetAttribute' => ['status_listing' => 'id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['verified_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['verified_by' => 'id']],
            [['approved_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['approved_by' => 'id']],
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
            // 'rr_number' => 'Rr Number',
            'created_by' => 'Created By',
            'verified_by' => 'Verified By',
            'approved_by' => 'Approved By',
            'updated_by' => 'Updated By',
            'created_date' => 'Created Date',
            'updated_date' => 'Updated Date',
            'status_listing' => 'Status Listing',
			'tgl_sj' => 'Tanggal SJ',
			'rr_date' => 'Tanggal RR',
			'po_number'=>'PO Number',
			'pr_number'=>'PR Number',
            'rr_number' => 'RR Number',
			'id_warehouse' => 'Warehouse Penerima',
            'file' => 'File Attachment'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatusReference()
    {
        return $this->hasOne(StatusReference::className(), ['id' => 'status_listing']);
    }
    public function getIdWarehouse()
    {
        return $this->hasOne(Warehouse::className(), ['id' => 'id_warehouse']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInboundPoDetails()
    {
        return $this->hasMany(InboundPoDetail::className(), ['id_inbound_po' => 'id']);
    }
	
	public function getOrafinPrToPay()
    {
        return $this->hasMany(OrafinViewMkmPrToPay::className(), ['rcv_no' => 'rr_number', 'po_num' => 'po_number']);
    }
	
	// public function getIdOrafinRr() 
   // { 
       // return $this->hasOne(OrafinRr::className(), ['id' => 'id_orafin_rr']); 
   // }
}
