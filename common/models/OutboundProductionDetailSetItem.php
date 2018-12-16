<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "outbound_production_detail_set_item".
 *
 * @property integer $id
 * @property integer $id_outbound_production_detail
 * @property integer $id_item_set
 * @property integer $req_good
 * @property integer $req_dis_good
 * @property integer $req_good_recond
 * @property integer $total
 *
 * @property OutboundProductionDetail $idOutboundProductionDetail
 */
class OutboundProductionDetailSetItem extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'outbound_production_detail_set_item';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_outbound_production_detail', 'id_item_set', 'req_good', 'req_dis_good', 'req_good_recond', 'total'], 'integer'],
            [['id_outbound_production_detail'], 'exist', 'skipOnError' => true, 'targetClass' => OutboundProductionDetail::className(), 'targetAttribute' => ['id_outbound_production_detail' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_outbound_production_detail' => 'Id Outbound Production Detail',
            'id_item_set' => 'Id Item Set',
            'req_good' => 'Req Good',
            'req_dis_good' => 'Req Dis Good',
            'req_good_recond' => 'Req Good Recond',
            'total' => 'Total',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdOutboundProductionDetail()
    {
        return $this->hasOne(OutboundProductionDetail::className(), ['id' => 'id_outbound_production_detail']);
    }

    public function getIdMasterItemIm()
    {
        return $this->hasOne(MasterItemIm::className(), ['id' => 'id_item_set']);
    }

    public function getStatusReference()
    {
        return $this->hasOne(StatusReference::className(), ['id' => 'status_listing']);
    }
}
