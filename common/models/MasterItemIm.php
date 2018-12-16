<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "master_item_im".
 *
 * @property integer $id
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $status
 * @property string $name
 * @property string $brand
 * @property string $created_date
 * @property string $updated_date
 * @property string $im_code
 * @property string $orafin_code
 * @property integer $sn_type
 * @property string $grouping
 * @property string $warna
 * @property string $stock_qty
 * @property string $s_good
 * @property string $s_not_good
 * @property string $s_reject
 * @property string $type
 * @property string $s_good_dismantle
 * @property string $s_not_good_dismantle
 *
 * @property InboundWhTransferDetail[] $inboundWhTransferDetails
 * @property InstructionDisposalDetailIm[] $instructionDisposalDetailIms
 * @property InstructionProductionDetail[] $instructionProductionDetails
 * @property InstructionRepairDetail[] $instructionRepairDetails
 * @property InstructionWhTransferDetail[] $instructionWhTransferDetails
 * @property StatusReference $status0
 * @property MasterItemImDetail[] $masterItemImDetails
 * @property OutboundRepairDetail[] $outboundRepairDetails
 * @property OutboundWhTransferDetail[] $outboundWhTransferDetails
 */
class MasterItemIm extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $qty_request;
	public $req_good_qty, $item_desc;
	public $s_good_dismantle, $s_not_good_dismantle, $item_code, $s_good, $s_not_good, $s_reject;
    public $s_dismantle, $s_revocation, $s_good_for_recond, $s_good_rec;

    public $qty_good_dismantle, $qty_not_good_dismantle, $qty_good, $qty_not_good, $qty_reject;
    public $qty_dismantle, $qty_revocation, $qty_good_for_recond, $qty_good_rec;
    public static function tableName()
    {
        return 'master_item_im';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status', 'name', 'brand', 'im_code', 'orafin_code', 'sn_type', 'grouping', 'warna', 'type'], 'required'],
            [['created_by', 'updated_by', 'status', 'sn_type', 'stock_qty', 's_good', 's_not_good', 's_reject', 's_good_dismantle', 's_not_good_dismantle', 's_dismantle', 's_revocation', 's_good_for_recond', 's_good_rec'], 'integer'],
            [['created_date', 'updated_date','item_code','item_desc'], 'safe'],
            [['name', 'brand', 'im_code', 'orafin_code', 'grouping', 'warna', 'type','uom'], 'string', 'max' => 255],
            [['status'], 'exist', 'skipOnError' => true, 'targetClass' => StatusReference::className(), 'targetAttribute' => ['status' => 'id']],
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
            'status' => 'Status',
            'name' => 'Name',
            'item_desc' => 'Name tess',
            'brand' => 'Brand',
            'created_date' => 'Created Date',
            'updated_date' => 'Updated Date',
            'im_code' => 'IM Code',
            'orafin_code' => 'Orafin Code',
            'item_code' => 'Orafin Code tes',
            'sn_type' => 'SN / Non SN',
            'grouping' => 'Grouping',
            'warna' => 'Warna',
            'stock_qty' => 'Stock Qty',
            's_good' => 'Stock Good',
            's_not_good' => 'Stock Not Good',
            's_reject' => 'Stock Reject',
            'type' => 'Type',
            'uom' => 'Uom',
            's_good_dismantle' => 'Stock Good Dismantle',
            's_not_good_dismantle' => 'Stock Not Good Dismantle',
            's_dismantle' => 'Stock Dismantle',
            's_revocation' => 'Stock Revocation',
            's_good_for_recond' => 'Stock Good for Recondition',
            's_good_rec' => 'Stock Good Recondition',

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
	
	
	public function getReferenceType()
    {
        return $this->hasOne(Reference::className(), ['id' => 'type']);
    }
	
	public function getReferenceWarna()
    {
        return $this->hasOne(Reference::className(), ['id' => 'warna']);
    }
	
	public function getReferenceBrand()
    {
        return $this->hasOne(Reference::className(), ['id' => 'brand']);
    }
	
	public function getReferenceGrouping()
    {
        return $this->hasOne(Reference::className(), ['id' => 'grouping']);
    }
	
	public function getReferenceSn()
    {
        return $this->hasOne(Reference::className(), ['id' => 'sn_type']);
    }

    public function getReferenceUom()
    {
        return $this->hasOne(Reference::className(), ['id' => 'uom']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInboundWhTransferDetails()
    {
        return $this->hasMany(InboundWhTransferDetail::className(), ['id_item_im' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInstructionDisposalDetailIms()
    {
        return $this->hasMany(InstructionDisposalDetailIm::className(), ['id_item_im' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInstructionProductionDetails()
    {
        return $this->hasMany(InstructionProductionDetail::className(), ['id_item_im' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInstructionRepairDetails()
    {
        return $this->hasMany(InstructionRepairDetail::className(), ['id_item_im' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInstructionWhTransferDetails()
    {
        return $this->hasMany(InstructionWhTransferDetail::className(), ['id_item_im' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatus0()
    {
        return $this->hasOne(StatusReference::className(), ['id' => 'status']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMasterItemImDetails()
    {
        return $this->hasMany(MasterItemImDetail::className(), ['id_master_item_im' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOutboundRepairDetails()
    {
        return $this->hasMany(OutboundRepairDetail::className(), ['id_item_im' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOutboundWhTransferDetails()
    {
        return $this->hasMany(OutboundWhTransferDetail::className(), ['id_item_im' => 'id']);
    }
    public function getGrfDetails()
    {
        return $this->hasMany(GrfDetail::className(), ['orafin_code' => 'orafin_code']);
    }
}
