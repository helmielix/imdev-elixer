<?php

namespace common\models;

use Yii;

use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
/**
 * This is the model class for table "inbound_wh_transfer".
 *
 * @property integer $id_outbound_wh
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $status_listing
 * @property string $arrival_date
 * @property string $production_date
 * @property string $created_date
 * @property string $updated_date
 * @property string $revision_remark
 * @property integer $id_modul
 *
 * @property Modul $idModul
 * @property StatusReference $statusListing
 * @property User $createdBy
 * @property User $updatedBy
 */
class InboundWhTransfer extends \yii\db\ActiveRecord
{
    public $no_sj, $wh_origin, $wh_destination, $id_item_im, $item_name, $im_code, $req_good, $brand, $arrived_good, $qty, $orafin_code, $id_inbound_detail, $grouping, $sn_type, $id_inbound_wh, $instruction_number, $plate_number, $driver, $req_qty, $qty_detail, $id_detail, $qty_good, $qty_not_good, $qty_reject, $qty_dismantle, $qty_revocation, $qty_good_rec, $qty_good_for_recond, $status_sn_need_approve, $id_outbound_wh_detail, $status_report, $delta;

    public static function tableName()
    {
        return 'inbound_wh_transfer';
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
            [['id_outbound_wh',  'id_modul'], 'required'],
			[['arrival_date',], 'required', 'on' => 'input_arrival'],
            [['id_outbound_wh', 'created_by', 'updated_by', 'status_listing', 'id_modul'], 'integer'],
            [['arrival_date', 'production_date', 'created_date', 'updated_date'], 'safe'],
            [['revision_remark'], 'string'],
            [['id_modul'], 'exist', 'skipOnError' => true, 'targetClass' => Modul::className(), 'targetAttribute' => ['id_modul' => 'id']],
            [['status_listing'], 'exist', 'skipOnError' => true, 'targetClass' => StatusReference::className(), 'targetAttribute' => ['status_listing' => 'id']],
            [['status_tagsn'], 'exist', 'skipOnError' => true, 'targetClass' => StatusReference::className(), 'targetAttribute' => ['status_tagsn' => 'id']],
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
            'id_outbound_wh' => 'Id Outbound WH',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'status_listing' => 'Status Listing',
            'status_tagsn' => 'Status',
            'arrival_date' => 'Tanggal Datang',
            'production_date' => 'Production Date',
            'created_date' => 'Created Date',
            'updated_date' => 'Updated Date',
            'revision_remark' => 'Revision Remark',
            'id_modul' => 'Id Modul',
			'no_sj' => 'Nomor Surat Jalan',
			'wh_origin' => 'Warehouse Asal',
			'qty_detail' => 'QTY Terima',
			'status_sn_need_approve' => 'Status Tag SN',
			'status_retagsn' => 'Status',
			'status_report' => 'Status',
            'instruction_number' => 'Nomor Instruksi',
        ];
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
    public function getStatusListing()
    {
        return $this->hasOne(StatusReference::className(), ['id' => 'status_listing']);
    }
	public function getStatusTagsn()
    {
        return $this->hasOne(StatusReference::className(), ['id' => 'status_tagsn']);
    }
	public function getStatusRetagsn()
    {
        return $this->hasOne(StatusReference::className(), ['id' => 'status_retagsn']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

	public function getIdOutboundWh()
    {
        return $this->hasOne(OutboundWhTransfer::className(), ['id_instruction_wh' => 'id_outbound_wh']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }
	
	public function getInboundWhTransferDetails()
    {
        return $this->hasMany(InboundWhTransferDetail::className(), ['id_inbound_wh' => 'id_outbound_wh']);
    }
}
