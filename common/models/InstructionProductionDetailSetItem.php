<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "instruction_production_detail_set_item".
 *
 * @property integer $id
 * @property integer $id_instruction_production_detail
 * @property integer $id_item_set
 * @property integer $req_good
 * @property integer $req_dis_good
 * @property integer $req_good_recond
 * @property integer $total
 *
 * @property InstructionProductionDetail $idInstructionProductionDetail
 */
class InstructionProductionDetailSetItem extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'instruction_production_detail_set_item';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_instruction_production_detail', 'id_item_set', 'req_good', 'req_dis_good', 'req_good_recond', 'total'], 'integer'],
            [['id_instruction_production_detail'], 'exist', 'skipOnError' => true, 'targetClass' => InstructionProductionDetail::className(), 'targetAttribute' => ['id_instruction_production_detail' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_instruction_production_detail' => 'Id Instruction Production Detail',
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
    public function getIdInstructionProductionDetail()
    {
        return $this->hasOne(InstructionProductionDetail::className(), ['id' => 'id_instruction_production_detail']);
    }
}
