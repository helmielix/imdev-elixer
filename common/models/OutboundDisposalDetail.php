<?php

namespace divisitiga\models;

use Yii;

/**
 * This is the model class for table "outbound_disposal_detail".
 *
 * @property int $id
 * @property int $id_outbound_disposal
 * @property int $id_item_im
 * @property int $qty
 * @property int $sn
 */
class OutboundDisposalDetail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'outbound_disposal_detail';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_outbound_disposal', 'id_item_im'], 'required'],
            [['id_outbound_disposal', 'id_item_im', 'qty', 'sn'], 'default', 'value' => null],
            [['id_outbound_disposal', 'id_item_im', 'qty', 'sn'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_outbound_disposal' => 'Id Outbound Disposal',
            'id_item_im' => 'Id Item Im',
            'qty' => 'Qty',
            'sn' => 'Sn',
        ];
    }
}
