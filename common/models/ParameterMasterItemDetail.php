<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "parameter_master_item_detail".
 *
 * @property integer $id
 * @property integer $id_item_parent
 * @property integer $id_item_child
 * @property integer $qty_item_child
 * @property integer $status_listing
 */
class ParameterMasterItemDetail extends \yii\db\ActiveRecord
{
   public $im_code, $name, $s_good, $s_good_dismantle, $s_good_rec, $brand, $type, $warna, $sn_type;

    public static function tableName()
    {
        return 'parameter_master_item_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_item_parent', 'id_item_child', 'qty_item_child', 'status_listing'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_item_parent' => 'Id Item Parent',
            'id_item_child' => 'Id Item Child',
            'qty_item_child' => 'Qty Item Child',
            'status_listing' => 'Status Listing',
        ];
    }

    public function getMasterItemParent()
    {
        return $this->hasOne(MasterItemIm::className(), ['id' => 'id_item_parent']);
    }

    public function getMasterItemChild()
    {
        return $this->hasOne(MasterItemIm::className(), ['id' => 'id_item_child']);
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
