<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "instruction_production_detail_supporting_item".
 *
 * @property integer $id
 * @property integer $id_instruction_production_detail
 * @property integer $id_item_support
 * @property integer $req_good
 * @property integer $req_dis_good
 * @property integer $req_good_recond
 * @property integer $total
 *
 * @property MasterItemIm $idItemSupport
 */
class InstructionProductionDetailSupportingItem extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'instruction_production_detail_supporting_item';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_instruction_production_detail', 'id_item_support', 'req_good', 'req_dis_good', 'req_good_recond', 'total'], 'integer'],
            [['id_item_support'], 'exist', 'skipOnError' => true, 'targetClass' => MasterItemIm::className(), 'targetAttribute' => ['id_item_support' => 'id']],
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
            'id_item_support' => 'Id Item Support',
            'req_good' => 'Req Good',
            'req_dis_good' => 'Req Dis Good',
            'req_good_recond' => 'Req Good Recond',
            'total' => 'Total',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdItemSupport()
    {
        return $this->hasOne(MasterItemIm::className(), ['id' => 'id_item_support']);
    }
}
