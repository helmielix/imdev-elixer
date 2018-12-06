<?php

namespace divisitiga\models;

use Yii;

/**
 * This is the model class for table "inbound_po_detail".
 *
 * @property integer $id
 * @property integer $id_inbound_po
 * @property integer $id_item_im
 * @property string $sn_type
 *
 * @property InboundPo $idInboundPo
 * @property InboundPoDetailSn[] $inboundPoDetailSns
 */
class InboundPoDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'inbound_po_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_inbound_po', 'id_item_im'], 'integer'],
            [['sn_type'], 'string', 'max' => 50],
            [['id_inbound_po'], 'exist', 'skipOnError' => true, 'targetClass' => InboundPo::className(), 'targetAttribute' => ['id_inbound_po' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_inbound_po' => 'Id Inbound Po',
            'id_item_im' => 'Id Item Im',
            'sn_type' => 'Sn Type',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdInboundPo()
    {
        return $this->hasOne(InboundPo::className(), ['id' => 'id_inbound_po']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInboundPoDetailSns()
    {
        return $this->hasMany(InboundPoDetailSn::className(), ['id_inbound_po_detail' => 'id']);
    }
}
