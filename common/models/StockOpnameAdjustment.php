<?php

namespace divisitiga\models;

use Yii;

/**
 * This is the model class for table "stock_opname_adjustment".
 *
 * @property integer $id
 * @property integer $id_master_item_im
 * @property integer $adj_good
 * @property integer $adj_not_good
 * @property integer $adj_reject
 * @property integer $adj_dismantle_good
 * @property integer $adj_dismantle_not_good
 * @property integer $adj_dismantle_reject
 * @property string $remarks
 * @property string $summary
 * @property string $file
 * @property integer $id_stock_opname_internal_detail
 *
 * @property MasterItemIm $idMasterItemIm
 * @property StockOpnameInternalDetail $idStockOpnameInternalDetail
 */
class StockOpnameAdjustment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'stock_opname_adjustment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_master_item_im', 'adj_good', 'adj_not_good', 'adj_reject', 'adj_dismantle_good', 'adj_dismantle_not_good', 'adj_dismantle_reject', 'id_stock_opname_internal_detail'], 'integer'],
            [['summary', 'file'], 'string'],
            [['remarks'], 'string', 'max' => 255],
            [['id_master_item_im'], 'exist', 'skipOnError' => true, 'targetClass' => MasterItemIm::className(), 'targetAttribute' => ['id_master_item_im' => 'id']],
            [['id_stock_opname_internal_detail'], 'exist', 'skipOnError' => true, 'targetClass' => StockOpnameInternalDetail::className(), 'targetAttribute' => ['id_stock_opname_internal_detail' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'id_master_item_im' => Yii::t('app', 'Id Master Item Im'),
            'adj_good' => Yii::t('app', 'Adj Good'),
            'adj_not_good' => Yii::t('app', 'Adj Not Good'),
            'adj_reject' => Yii::t('app', 'Adj Reject'),
            'adj_dismantle_good' => Yii::t('app', 'Adj Dismantle Good'),
            'adj_dismantle_not_good' => Yii::t('app', 'Adj Dismantle Not Good'),
            'adj_dismantle_reject' => Yii::t('app', 'Adj Dismantle Reject'),
            'remarks' => Yii::t('app', 'Remarks'),
            'summary' => Yii::t('app', 'Summary'),
            'file' => Yii::t('app', 'File'),
            'id_stock_opname_internal_detail' => Yii::t('app', 'Id Stock Opname Internal Detail'),
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
    public function getIdStockOpnameInternalDetail()
    {
        return $this->hasOne(StockOpnameInternalDetail::className(), ['id' => 'id_stock_opname_internal_detail']);
    }
}
