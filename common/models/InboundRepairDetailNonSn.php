<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "inbound_repair_detail_non_sn".
 *
 * @property integer $id_non_sn
 * @property integer $good
 * @property integer $reject
 * @property integer $delta
 * @property integer $id_inbound_repair_detail
 *
 * @property InboundRepairDetail $idInboundRepairDetail
 */
class InboundRepairDetailNonSn extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'inbound_repair_detail_non_sn';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
//            [['id_non_sn'], 'required'],
            [['id_non_sn', 'good', 'reject', 'delta', 'id_inbound_repair_detail'], 'integer'],
            [['id_inbound_repair_detail'], 'exist', 'skipOnError' => true, 'targetClass' => InboundRepairDetail::className(), 'targetAttribute' => ['id_inbound_repair_detail' => 'id_inbound_repair_detail']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_non_sn' => Yii::t('app', 'Id Non Sn'),
            'good' => Yii::t('app', 'Good'),
            'reject' => Yii::t('app', 'Reject'),
            'delta' => Yii::t('app', 'Delta'),
            'id_inbound_repair_detail' => Yii::t('app', 'Id Inbound Repair Detail'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdInboundRepairDetail()
    {
        return $this->hasOne(InboundRepairDetail::className(), ['id_inbound_repair_detail' => 'id_inbound_repair_detail']);
    }
}
