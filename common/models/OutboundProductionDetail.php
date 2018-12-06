<?php

namespace divisitiga\models;

use Yii;

/**
 * This is the model class for table "outbound_production_detail".
 *
 * @property int $id
 * @property int $id_outbound_production
 * @property int $id_item_im
 * @property int $qty
 * @property int $sn
 *
 * @property ItemIm $itemIm
 */
class OutboundProductionDetail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'outbound_production_detail';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_outbound_production', 'id_item_im', 'qty', 'sn'], 'required'],
            [['id_outbound_production', 'id_item_im', 'qty', 'sn'], 'default', 'value' => null],
            [['id_outbound_production', 'id_item_im', 'qty', 'sn'], 'integer'],
            [['id_item_im'], 'exist', 'skipOnError' => true, 'targetClass' => ItemIm::className(), 'targetAttribute' => ['id_item_im' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_outbound_production' => 'Id Outbound Production',
            'id_item_im' => 'Id Item Im',
            'qty' => 'Qty',
            'sn' => 'Sn',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItemIm()
    {
        return $this->hasOne(ItemIm::className(), ['id' => 'id_item_im']);
    }
}
