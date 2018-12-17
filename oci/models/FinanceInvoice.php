<?php

namespace ap\models;

use Yii;
use common\models\StatusReference;
use common\models\Reference;
use common\models\User;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
/**
 * This is the model class for table "invoice".
 *
 * @property integer $id
 * @property integer $po_id
 * @property string $invoice_number
 * @property string $order_number
 * @property string $invoice_date
 * @property string $invoice_due_date
 * @property string $invoice_type
 * @property integer $percentage
 * @property string $pic_vendor
 * @property string $pic_vendor_position
 * @property string $note
 * @property string $upload_invoice
 * @property string $pic_finance
 * @property integer $created_by
 * @property string $created_date
 * @property integer $updated_by
 * @property string $updated_date
 * @property integer $status_listing
 */
class FinanceInvoice extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
	public $file,$position;

    public static function tableName()
    {
        return 'finance_invoice';
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
            [['percentage', 'created_by', 'updated_by', 'status_listing', 'vendor_name'], 'integer'],
            [['invoice_date', 'invoice_due_date', 'created_date', 'updated_date'], 'safe'],
            [['revision_remark'], 'string'],
            [['invoice_number', 'order_number',  'pic_vendor', 'pic_vendor_position', 'upload_invoice', 'pic_finance'], 'string', 'max' => 50],
            [['pic_finance'], 'exist', 'skipOnError' => true, 'targetClass' => Labor::className(), 'targetAttribute' => ['pic_finance' => 'nik']],
            [['status_listing'], 'exist', 'skipOnError' => true, 'targetClass' => StatusReference::className(), 'targetAttribute' => ['status_listing' => 'id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_by' => 'id']],
			[['vendor_name'], 'exist', 'skipOnError' => true, 'targetClass' => Vendor::className(), 'targetAttribute' => ['vendor_name' => 'id']],
			[['file'], 'file',  'extensions' => 'pdf,jpg,png', 'maxSize'=>1024*1024*5],
			[['file','vendor_name', 'invoice_date', 'invoice_due_date', 'invoice_type', 'percentage', 'pic_vendor', 'pic_vendor_position', 'pic_finance' ,'invoice_number','order_number', 'id_os_vendor_pob'], 'required', 'on'=>'create'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'po_id' => 'Po ID',
            'invoice_number' => 'Invoice Number',
            'order_number' => 'Order Number',
            'invoice_date' => 'Invoice Date',
            'invoice_due_date' => 'Invoice Due Date',
            'invoice_type' => 'Invoice Type',
            'percentage' => 'Percentage (%)',
            'pic_vendor' => 'Pic Vendor',
            'pic_vendor_position' => 'Pic Vendor Position',
            'revision_remark' => 'Revision Remark',
            'upload_invoice' => 'Upload Invoice',
            'pic_finance' => 'Pic Finance',
            'created_by' => 'Created By',
            'created_date' => 'Created Date',
            'updated_by' => 'Updated By',
            'updated_date' => 'Updated Date',
            'status_listing' => 'Status Listing',
			'vendor_name' => 'Vendor Name',
			'note' => 'Note',
			'id_os_vendor_pob' => 'POB Number',
        ];
    }

	public function getStatusReference()
	{
		return $this->hasOne(StatusReference::classname(), ['id' => 'status_listing']);
	}

	public function getVendor()
	{
		return $this->hasOne(Vendor::classname(), ['id' => 'vendor_name']);
	}
	
	public function getFinanceInvoiceDocuments()
   {
       return $this->hasMany(FinanceInvoiceDocument::className(), ['id_finance_invoice' => 'id']);
   }
}
