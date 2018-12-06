<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "outbound_repair".
 *
 * @property integer $id_instruction_repair
 * @property integer $driver
 * @property integer $created_by
 * @property integer $status_listing
 * @property integer $updated_by
 * @property integer $forwarder
 * @property string $no_sj
 * @property string $plate_number
 * @property string $created_date
 * @property string $updated_date
 * @property string $revision_remark
 * @property integer $id_modul
 *
 * @property InstructionRepair $idInstructionRepair
 * @property Modul $idModul
 * @property Reference $forwarder0
 * @property StatusReference $statusListing
 * @property User $createdBy
 * @property User $updatedBy
 * @property OutboundRepairDetail[] $outboundRepairDetails
 */
class InboundRepairTagging extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    //public $instruction_number, $target_pengiriman, $vendor_repair, $wh_destination, $wh_origin, $grf_number;
    public $name, $im_code, $brand, $sn_type, $status;
    public static function tableName()
    {
        return 'inbound_repair_tagging';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            /*[['id_instruction_repair', 'id_modul'], 'required'],
            [['id_instruction_repair', 'created_by', 'status_listing', 'updated_by', 'forwarder', 'id_modul'], 'integer'],
            [['created_date', 'updated_date'], 'safe'],
            [['revision_remark'], 'string'],
            [['driver'], 'string', 'max' => 50],
            [['no_sj', 'plate_number'], 'string', 'max' => 255],
            [['id_instruction_repair'], 'exist', 'skipOnError' => true, 'targetClass' => InstructionRepair::className(), 'targetAttribute' => ['id_instruction_repair' => 'id']],
            [['id_modul'], 'exist', 'skipOnError' => true, 'targetClass' => Modul::className(), 'targetAttribute' => ['id_modul' => 'id']],
            [['forwarder'], 'exist', 'skipOnError' => true, 'targetClass' => Reference::className(), 'targetAttribute' => ['forwarder' => 'id']],
            [['status_listing'], 'exist', 'skipOnError' => true, 'targetClass' => StatusReference::className(), 'targetAttribute' => ['status_listing' => 'id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_by' => 'id']], */
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_tagging' => 'ID',
            'status_listing' => 'Status',
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
    public function getInstructionRepair()
    {
        return $this->hasMany(InboundRepair::className(), ['id' => 'id_tagging']);
    }

    public function getStatusReference()
    {
        return $this->hasOne(StatusReference::className(), ['id' => 'status_listing']);
    }
}
