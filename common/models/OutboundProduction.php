<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
/**
 * This is the model class for table "outbound_production".
 *
 * @property int $id_instruction_production
 * @property int $created_by
 * @property int $updated_by
 * @property int $forwarder
 * @property int $status_listing
 * @property string $created_date
 * @property string $updated_date
 * @property string $revision_remark
 * @property string $no_sj
 * @property string $plate_number
 * @property string $driver
 * @property string $file_attachment
 *
 * @property Reference $forwarder0
 * @property StatusReference $statusListing
 * @property User $createdBy
 * @property User $updatedBy
 */
class OutboundProduction extends \yii\db\ActiveRecord
{
    public $instruction_number;

    public static function tableName()
    {
        return 'outbound_production';
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
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_instruction_production',], 'required'],
            [['id_instruction_production',  'forwarder', 'status_listing'], 'default', 'value' => null],
            [['id_instruction_production',  'forwarder', 'status_listing'], 'integer'],
            [['created_date', 'updated_date'], 'safe'],
            [['revision_remark', 'plate_number'], 'string'],
            [['no_sj', 'driver', 'file_attachment'], 'string', 'max' => 255],
            [['id_instruction_production'], 'unique'],
            [['forwarder'], 'exist', 'skipOnError' => true, 'targetClass' => Reference::className(), 'targetAttribute' => ['forwarder' => 'id']],
            [['status_listing'], 'exist', 'skipOnError' => true, 'targetClass' => StatusReference::className(), 'targetAttribute' => ['status_listing' => 'id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_by' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_instruction_production' => 'Id Instruction Production',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'forwarder' => 'Forwarder',
            'status_listing' => 'Status Listing',
            'created_date' => 'Created Date',
            'updated_date' => 'Updated Date',
            'revision_remark' => 'Revision Remark',
            'no_sj' => 'No Surat Jalan',
            'plate_number' => 'Plate Number',
            'driver' => 'Driver',
            'file_attachment' => 'File Attachment',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getForwarder0()
    {
        return $this->hasOne(Reference::className(), ['id' => 'forwarder']);
    }

    public function getIdInstructionProduction()
    {
        return $this->hasOne(InstructionProduction::className(), ['id' => 'id_instruction_production']);
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
}
