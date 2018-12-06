<?php

namespace common\models;

use Yii;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "instruction_production_detail".
 *
 * @property integer $id
 * @property integer $id_instruction_production
 * @property integer $id_item_im
 * @property integer $created_by
 * @property integer $req_good
 * @property integer $req_not_good
 * @property integer $req_reject
 *
 * @property InstructionProduction $idInstructionWh
 * @property ItemIm $idItemIm
 * @property User $createdBy
 */
class InstructionProductionDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'instruction_production_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_instruction_production', 'id_item_im'], 'required'],
            [['id_instruction_production', 'id_item_im', 'created_by', 'req_good', 'req_not_good', 'req_reject'], 'integer'],
            [['id_instruction_production'], 'exist', 'skipOnError' => true, 'targetClass' => InstructionProduction::className(), 'targetAttribute' => ['id_instruction_production' => 'id']],
            // [['id_item_im'], 'exist', 'skipOnError' => true, 'targetClass' => ItemIm::className(), 'targetAttribute' => ['id_item_im' => 'id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_instruction_production' => 'Id Instruction Production',
            'id_item_im' => 'Id Item Im',
            'created_by' => 'Created By',
            'req_good' => 'Req Good',
            'req_not_good' => 'Req Not Good',
            'req_reject' => 'Req Reject',
        ];
    }

	public function behaviors()
	{
		return [
			'blameable' => [
				'class' => BlameableBehavior::className(),
				'createdByAttribute' => 'created_by',
				'updatedByAttribute' => false,
			],
		];
	}

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdInstructionWh()
    {
        return $this->hasOne(InstructionProduction::className(), ['id' => 'id_instruction_production']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdMasterItemIm()
    {
        return $this->hasOne(MasterItemIm::className(), ['id' => 'id_item_im']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }
}
