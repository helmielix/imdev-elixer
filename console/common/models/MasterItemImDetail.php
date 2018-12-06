<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "master_item_im_detail".
 *
 * @property integer $id
 * @property integer $id_master_item_im
 * @property integer $id_warehouse
 * @property string $s_good
 * @property string $s_not_good
 * @property string $s_reject
 * @property string $s_good_dismantle
 * @property string $s_not_good_dismantle
 *
 * @property MasterItemIm $idMasterItemIm
 * @property Warehouse $idWarehouse
 */
class MasterItemImDetail extends \yii\db\ActiveRecord
{
    public $im_code, $grouping, $brand, $warna, $type,  $req_good_qty;
    // public $s_good, $s_not_good, $s_reject, $s_good_dismantle, $s_not_good_dismantle;

    public static function tableName()
    {
        return 'master_item_im_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_master_item_im', 'id_warehouse'], 'required'],
            [['id_master_item_im', 'id_warehouse', 's_good', 's_not_good', 's_reject', 's_good_dismantle', 's_not_good_dismantle'], 'integer'],
            [['id_master_item_im'], 'exist', 'skipOnError' => true, 'targetClass' => MasterItemIm::className(), 'targetAttribute' => ['id_master_item_im' => 'id']],
            [['id_warehouse'], 'exist', 'skipOnError' => true, 'targetClass' => Warehouse::className(), 'targetAttribute' => ['id_warehouse' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_master_item_im' => 'Id Master Item Im',
            'id_warehouse' => 'Id Warehouse',
            's_good' => 'S Good',
            's_not_good' => 'S Not Good',
            's_reject' => 'S Reject',
            's_good_dismantle' => 'S Good Dismantle',
            's_not_good_dismantle' => 'S Not Good Dismantle',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdMasterItemIm()
    {
        return $this->hasOne(MasterItemIm::className(), ['id' => 'id_master_item_im']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdWarehouse()
    {
        return $this->hasOne(Warehouse::className(), ['id' => 'id_warehouse']);
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
