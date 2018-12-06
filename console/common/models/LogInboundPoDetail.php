<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "log_inbound_po_detail".
 *
 * @property integer $idlog
 * @property integer $id
 * @property integer $id_inbound_po
 * @property integer $id_item_im
 * @property integer $qty
 * @property integer $status_listing
 * @property string $orafin_code
 * @property integer $qty_good
 * @property integer $qty_not_good
 * @property integer $qty_reject
 * @property integer $qty_rr
 */
class LogInboundPoDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'log_inbound_po_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_inbound_po', 'id_item_im', 'qty', 'status_listing', 'qty_good', 'qty_not_good', 'qty_reject', 'qty_rr'], 'integer'],
            [['orafin_code'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idlog' => 'Idlog',
            'id' => 'ID',
            'id_inbound_po' => 'Id Inbound Po',
            'id_item_im' => 'Id Item Im',
            'qty' => 'Qty',
            'status_listing' => 'Status Listing',
            'orafin_code' => 'Orafin Code',
            'qty_good' => 'Qty Good',
            'qty_not_good' => 'Qty Not Good',
            'qty_reject' => 'Qty Reject',
            'qty_rr' => 'Qty Rr',
        ];
    }

    public function getItemIm()
    {
        return $this->hasOne(MasterItemIm::className(), ['id' => 'id_item_im']);
    }
}
