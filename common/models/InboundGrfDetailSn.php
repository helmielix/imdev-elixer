<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "inbound_grf_detail_sn".
 *
 * @property integer $id
 * @property integer $id_inbound_grf_detail
 * @property integer $sn
 *
 * @property InboundGrfDetail $idInboundGrfDetail
 */
class InboundGrfDetailSn extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'inbound_grf_detail_sn';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_inbound_grf_detail', 'sn'], 'required'],
            [['id_inbound_grf_detail', 'sn'], 'integer'],
            [['id_inbound_grf_detail'], 'exist', 'skipOnError' => true, 'targetClass' => InboundGrfDetail::className(), 'targetAttribute' => ['id_inbound_grf_detail' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_inbound_grf_detail' => 'Id Inbound Grf Detail',
            'sn' => 'Sn',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdInboundGrfDetail()
    {
        return $this->hasOne(InboundGrfDetail::className(), ['id' => 'id_inbound_grf_detail']);
    }
}
