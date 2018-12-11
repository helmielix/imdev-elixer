<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use common\models\User;

/**
 * This is the model class for table "instruction_disposal".
 *
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $status_listing
 * @property integer $no_iom
 * @property integer $warehouse
 * @property integer $buyer
 * @property integer $instruction_number
 * @property string $created_date
 * @property string $updated_date
 * @property string $target_implementation
 * @property string $revision_remark
 * @property string $file_attachment
 * @property integer $id_modul
 * @property integer $id
 *
 * @property Modul $idModul
 * @property Reference $buyer0
 * @property StatusReference $statusListing
 * @property User $createdBy
 * @property User $updatedBy
 * @property Warehouse $warehouse0
 */
class InstructionDisposal extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $file;
    public $id_disposal_am, $target_pelaksanaan;

    public static function tableName()
    {
        return 'instruction_disposal';
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
            [['no_iom', 'id_warehouse',  'date_iom', 'id_modul'], 'required'],
            [['created_by', 'updated_by', 'status_listing', 'id_warehouse', 'id_modul'], 'integer'],
            [['instruction_number'], 'string', 'max' => 26],
            [['no_iom'], 'string', 'max' => 26],
            [['created_date', 'updated_date','estimasi_disposal', 'date_iom', 'target_implementation'], 'safe'],
            [['file_attachment' ], 'string', 'max' => 255],
            [['revision_remark'], 'string'],
            [['id_modul'], 'exist', 'skipOnError' => true, 'targetClass' => Modul::className(), 'targetAttribute' => ['id_modul' => 'id']],
            // [['buyer'], 'exist', 'skipOnError' => true, 'targetClass' => Reference::className(), 'targetAttribute' => ['buyer' => 'id']],
            [['status_listing'], 'exist', 'skipOnError' => true, 'targetClass' => StatusReference::className(), 'targetAttribute' => ['status_listing' => 'id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_by' => 'id']],
            [['id_warehouse'], 'exist', 'skipOnError' => true, 'targetClass' => Warehouse::className(), 'targetAttribute' => ['id_warehouse' => 'id']],
            [['file'], 'file', 'extensions' => 'xls,xlsx', 'maxSize'=>1024*1024*5],
            [['file'], 'required', 'on'=>'create'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'status_listing' => 'Status Listing',
            'no_iom' => 'Nomor IOM',
            'id_warehouse' => 'Warehouse',
            'buyer' => 'Buyer',
            'instruction_number' => 'Instruction Number',
            'file_attachment' => 'IOM File',
            'file' => 'IOM File',
            'created_date' => 'Created Date',
            'updated_date' => 'Updated Date',
            'target_implementation' => 'Target Implementation',
            'revision_remark' => 'Note',
            'id_modul' => 'Id Modul',
            'id' => 'ID',
            'date_iom' => 'Tanggal IOM'
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
    public function getBuyer0()
    {
        return $this->hasOne(Reference::className(), ['id' => 'buyer']);
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
    public function getWarehouse0()
    {
        return $this->hasOne(Warehouse::className(), ['id' => 'warehouse']);
    }
}
