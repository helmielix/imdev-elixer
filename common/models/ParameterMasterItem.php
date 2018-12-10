<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
/**
 * This is the model class for table "parameter_master_item".
 *
 * @property integer $id
 * @property integer $id_item
 * @property integer $status_listing
 * @property integer $created_by
 * @property string $created_date
 * @property integer $updated_by
 * @property string $updated_date
 */
class ParameterMasterItem extends \yii\db\ActiveRecord
{
    public $item_name, $item_orafin, $grouping, $brand, $type, $warna, $uom, $sn, $name, $im_code, $s_good, $s_good_dismantle, $s_good_rec, $sn_type, $id_item_im, $id_parameter; 

    public static function tableName()
    {
        return 'parameter_master_item';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_item', 'status_listing', 'created_by', 'updated_by'], 'integer'],
            [['created_date', 'updated_date'], 'safe'],
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
            'id_item' => 'Id Item',
            'status_listing' => 'Status Listing',
            'created_by' => 'Created By',
            'created_date' => 'Created Date',
            'updated_by' => 'Updated By',
            'updated_date' => 'Updated Date',
        ];
    }

    public function getStatusReference()
    {
        return $this->hasOne(StatusReference::className(), ['id' => 'status_listing']);
    }

    public function getIdMasterItemIm()
    {
        return $this->hasOne(MasterItemIm::className(), ['id' => 'id_item']);
    }

    public function getParameterMasterItemDetails()
    {
        return $this->hasMany(MasterItemIm::className(), ['id' => 'id_parameter']);
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
}
