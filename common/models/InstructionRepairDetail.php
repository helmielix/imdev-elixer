<?php

namespace common\models;

use Yii;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "instruction_repair_detail".
 *
 * @property integer $id
 * @property integer $id_instruction_repair
 * @property integer $id_item_im
 * @property integer $created_by
 * @property integer $req_good
 * @property integer $req_not_good
 * @property integer $req_reject
 *
 * @property InstructionRepair $idInstructionWh
 * @property ItemIm $idItemIm
 * @property User $createdBy
 */
class InstructionRepairDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    // public $name;
    public static function tableName()
    {
        return 'instruction_repair_detail';
    }

    /**
     * @inheritdoc
     */
    public $name;
    public $type;
    public $warna;
    public $sn_type;
    public $s_good;
    public $s_reject;
    public function rules()
    {
        return [
            [['id_instruction_repair', 'id_item_im'], 'required'],
            [['id_instruction_repair', 'id_item_im', 'created_by', 'req_good', 'req_not_good', 'req_reject','rem_reject'], 'integer'],
            // [['name'], 'safe'],
            [['id_instruction_repair'], 'exist', 'skipOnError' => true, 'targetClass' => InstructionRepair::className(), 'targetAttribute' => ['id_instruction_repair' => 'id']],
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
            'id_instruction_repair' => 'Id Instruction Repair',
            'id_item_im' => 'Im Code',
            'created_by' => 'Created By',
            'req_good' => 'Req.Good',
            'req_reject' => 'Req.Reject',
            'name' => 'Nama Barang',
            'rem_reject' => 'Rem.Reject',
            'sn_type' => 'SN/Non SN',
            's_good' => 'S.Good',
            's_reject' => 'S.Reject',
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
        return $this->hasOne(InstructionRepair::className(), ['id' => 'id_instruction_repair']);
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
