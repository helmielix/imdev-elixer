<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
/**
 * This is the model class for table "stock_opname_internal".
 *
 * @property integer $id
 * @property integer $stock_opname_number
 * @property integer $updated_by
 * @property integer $created_by
 * @property integer $id_warehouse
 * @property integer $status_listing
 * @property string $file
 * @property string $revision_remark
 * @property string $cut_off_data_date
 * @property string $cut_off_data_time
 * @property string $sto_date
 * @property string $created_date
 * @property string $start_date
 * @property string $end_date
 * @property string $updated_date
 * @property integer $id_modul
 * @property integer $pic
 *
 * @property Modul $idModul
 * @property StatusReference $statusListing
 * @property User $updatedBy
 * @property User $createdBy
 * @property User $PIC
 * @property Warehouse $idWarehouse
 */
class StockOpnameInternal extends \yii\db\ActiveRecord
{
    public $file;
    public static function tableName()
    {
        return 'stock_opname_internal';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pic',  'id_warehouse', 'stock_opname_number',  'id_modul'], 'required'],
            [['stock_opname_number', 'id_warehouse', 'status_listing', 'id_modul'], 'integer'],
            [['created_date', 'updated_date'], 'safe'],
            [['file', 'revision_remark'], 'string'],
            [['id_modul'], 'exist', 'skipOnError' => true, 'targetClass' => Modul::className(), 'targetAttribute' => ['id_modul' => 'id']],
            [['status_listing'], 'exist', 'skipOnError' => true, 'targetClass' => StatusReference::className(), 'targetAttribute' => ['status_listing' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_by' => 'id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['id_warehouse'], 'exist', 'skipOnError' => true, 'targetClass' => Warehouse::className(), 'targetAttribute' => ['id_warehouse' => 'id']],
            [['file'], 'file', 'extensions' => 'xls,xlsx', 'maxSize'=>1024*1024*5],
      			[['file'], 'required', 'on'=>'create'],
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
            'updated_by' => 'Updated By',
            'created_by' => 'Created By',
            'pic' => 'PIC',
            'id_warehouse' => 'Id Warehouse',
            'status_listing' => 'Status Listing',
            'file' => 'File Attachment',
            'revision_remark' => 'Revision Remark',
            'created_date' => 'Created Date',
            'updated_date' => 'Updated Date',
            'id_modul' => 'Id Modul',
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
    public function getStatusReference()
    {
        return $this->hasOne(StatusReference::className(), ['id' => 'status_listing']);
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
    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdWarehouse()
    {
        return $this->hasOne(Warehouse::className(), ['id' => 'id_warehouse']);
    }
}
