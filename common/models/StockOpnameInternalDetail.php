<?php

namespace divisitiga\models;

// namespace app\models;

use Yii;

/**
 * This is the model class for table "stock_opname_internal_detail".
 *
 * @property integer $id
 * @property integer $id_stock_opname_internal
 * @property integer $id_item_im
 * @property integer $f_good
 * @property integer $f_not_good
 * @property integer $f_reject
 * @property integer $d_good
 * @property integer $d_not_good
 * @property integer $d_reject
 *
 * @property MasterItemIm $idItemIm
 * @property StockOpnameInternal $idStockOpnameInternal
 *  @property StockOpnameAdjustment[] $stockOpnameAdjustments
 */
class StockOpnameInternalDetail extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'stock_opname_internal_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['id_stock_opname_internal', 'id_item_im'], 'required'],
            [['id_stock_opname_internal', 'id_item_im', 'f_good', 'f_not_good', 'f_reject', 'd_good', 'd_not_good', 'd_reject'], 'integer'],
            [['id_item_im'], 'exist', 'skipOnError' => true, 'targetClass' => MasterItemIm::className(), 'targetAttribute' => ['id_item_im' => 'id']],
            [['id_stock_opname_internal'], 'exist', 'skipOnError' => true, 'targetClass' => StockOpnameInternal::className(), 'targetAttribute' => ['id_stock_opname_internal' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('app', 'ID'),
            'id_stock_opname_internal' => Yii::t('app', 'Id Stock Opname Internal'),
            'id_item_im' => Yii::t('app', 'Id Item Im'),
            'f_good' => Yii::t('app', 'F Good'),
            'f_not_good' => Yii::t('app', 'F Not Good'),
            'f_reject' => Yii::t('app', 'F Reject'),
            'd_good' => Yii::t('app', 'D Good'),
            'd_not_good' => Yii::t('app', 'D Not Good'),
            'd_reject' => Yii::t('app', 'D Reject'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery 
     */
//    public function getStockOpnameAdjustments() {
//        return $this->hasMany(StockOpnameAdjustment::className(), ['id_stock_opname_internal_detail' => 'id']);
//    }
    public function getStockOpnameAdjustments() {
        return $this->hasMany(StockOpnameAdjustment::className(), ['id_stock_opname_internal_detail' => 'id','id_master_item_im'=>'id_item_im' ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdItemIm() {
        return $this->hasOne(MasterItemIm::className(), ['id' => 'id_item_im']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdStockOpnameInternal() {
        return $this->hasOne(StockOpnameInternal::className(), ['id' => 'id_stock_opname_internal']);
    }

    public static function getDetailById($param) {
        $query = new \yii\db\Query;
        $query->select('*')
                ->from('stock_opname_internal s1')
//            ->leftJoin('stock_opname_internal_detail s2', 's1.id AND s1.id = (SELECT MAX(id) FROM table2 s2 WHERE s2.g_id = g1.id')  
//            ->limit();
        ;
        $command = $query->createCommand();
        $resp = $command->queryAll();
        return $resp;
    }

}
