<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "instruction_wh_transfer".
 *
 * @property integer $id
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $status_listing
 * @property integer $wh_destination
 * @property integer $instruction_number
 * @property string $delivery_target_date
 * @property string $file_attachment
 * @property string $created_date
 * @property string $updated_date
 * @property string $grf_number
 * @property integer $wh_origin
 *
 * @property InboundWhTransferDetail[] $inboundWhTransferDetails
 * @property StatusReference $statusListing
 * @property User $createdBy
 * @property User $updatedBy
 * @property Warehouse $whDestination
 * @property Warehouse $whOrigin
 * @property InstructionWhTransferDetail[] $instructionWhTransferDetails
 */
class LogInstructionWhTransfer extends \yii\db\ActiveRecord
{
    public $file;
    public static function tableName()
    {
        return 'log_instruction_wh_transfer';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['wh_destination', 'instruction_number', 'delivery_target_date', 'wh_origin'], 'required'],
            [['id','id_modul','created_by', 'updated_by', 'status_listing', 'wh_destination', 'wh_origin'], 'integer'],
			      [['instruction_number'], 'string', 'max' => 26],
            [['delivery_target_date', 'created_date', 'updated_date','revision_remark'], 'safe'],
            [['file_attachment', 'grf_number'], 'string', 'max' => 255],
            // [['status_listing'], 'exist', 'skipOnError' => true, 'targetClass' => StatusReference::className(), 'targetAttribute' => ['status_listing' => 'id']],

            // [['wh_destination'], 'exist', 'skipOnError' => true, 'targetClass' => Warehouse::className(), 'targetAttribute' => ['wh_destination' => 'id']],
            // [['wh_origin'], 'exist', 'skipOnError' => true, 'targetClass' => Warehouse::className(), 'targetAttribute' => ['wh_origin' => 'id']],
      			// [['wh_destination'], 'compare', 'operator' => '!=', 'compareAttribute' => 'wh_origin'],
      			// [['file'], 'file', 'extensions' => 'xls,xlsx', 'maxSize'=>1024*1024*5],
      			// [['file'], 'required', 'on'=>'create'],
      			// [['delivery_target_date'], 'date', 'format' => 'php:Y-m-d', 'max' => date('Y-m-d')],
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
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'status_listing' => 'Status Listing',
            'wh_destination' => 'Wh Destination',
            'instruction_number' => 'Instruction Number',
            'delivery_target_date' => 'Delivery Target Date',
            'file_attachment' => 'File Attachment',
            'file' => 'File Attachment',
            'created_date' => 'Created Date',
            'updated_date' => 'Updated Date',
            'grf_number' => 'Grf Number',
            'wh_origin' => 'Wh Origin',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInboundWhTransferDetails()
    {
        return $this->hasMany(InboundWhTransferDetail::className(), ['id_inbound_wh' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatusReference()
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
    public function getWhDestination()
    {
        return $this->hasOne(Warehouse::className(), ['id' => 'wh_destination']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWhOrigin()
    {
        return $this->hasOne(Warehouse::className(), ['id' => 'wh_origin']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInstructionWhTransferDetails()
    {
        return $this->hasMany(InstructionWhTransferDetail::className(), ['id_instruction_wh' => 'id']);
    }
}
