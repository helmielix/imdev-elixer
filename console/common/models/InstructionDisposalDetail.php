<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "instruction_disposal_detail".
 *
 * @property integer $id
 * @property integer $id_instruction_disposal
 * @property integer $id_item_im
 * @property integer $req_good
 * @property integer $req_not_good
 * @property integer $req_reject
 */
class InstructionDisposalDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $name,$brand,$uom_;
    public static function tableName()
    {
        return 'instruction_disposal_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['im_code','id_instruction_disposal'], 'required'],
            [['qty', 'qty_konversi', 'id_instruction_disposal'], 'integer'],
            [['im_code','uom_sale', 'uom_old', 'uom_new','name_item', 'brand','uom','konversi', 'qty_total'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_instruction_disposal' => 'Id Instruction Disposal',
            'im_code' => 'Im Code',
            'name' => 'Name',
            'brand' => 'Brand',
            'uom_' => 'Uom',
            'qty' => 'Qty',
            'uom_sale' => 'Uom Penjualan',
            'qty_konversi' => 'Qty Konversi',
            'uom_old' => 'Uom Lama',
            'konversi' => 'Konversi',
            'uom_new' => 'Uom Baru',
            'qty_total' => 'Qty Total',
            'uom' => 'Uom',
        ];
    }
     public function getIdInstructionDisposal()
    {
        return $this->hasOne(InstructionDisposal::className(), ['id' => 'id_instruction_disposal']);
    }
    public function getImCode()
    {
        return $this->hasOne(MasterItemIm::className(), ['id' => 'im_code']);
    }
}
