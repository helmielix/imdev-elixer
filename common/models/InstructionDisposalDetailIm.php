<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "instruction_disposal_detail_im".
 *
 * @property integer $id
 * @property integer $id_disposal_im
 * @property integer $id_item_im
 * @property integer $id_disposal_detail
 * @property integer $created_by
 * @property integer $req_good
 * @property integer $req_not_good
 * @property integer $req_reject
 * @property integer $req_good_dismantle
 * @property integer $req_not_good_dismantle
 *
 * @property InstructionDisposalDetail $idDisposalDetail
 * @property InstructionDisposalIm $idDisposalIm
 * @property MasterItemIm $idItemIm
 * @property User $createdBy
 */
class InstructionDisposalDetailIm extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'instruction_disposal_detail_im';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_disposal_im', 'id_item_im', 'id_disposal_detail', 'created_by'], 'required'],
            [['id', 'id_disposal_im', 'id_item_im', 'id_disposal_detail', 'created_by', 'req_good', 'req_not_good', 'req_reject', 'req_good_dismantle', 'req_not_good_dismantle'], 'integer'],
            [['id_disposal_detail'], 'exist', 'skipOnError' => true, 'targetClass' => InstructionDisposalDetail::className(), 'targetAttribute' => ['id_disposal_detail' => 'id']],
            [['id_disposal_im'], 'exist', 'skipOnError' => true, 'targetClass' => InstructionDisposalIm::className(), 'targetAttribute' => ['id_disposal_im' => 'id']],
            [['id_item_im'], 'exist', 'skipOnError' => true, 'targetClass' => MasterItemIm::className(), 'targetAttribute' => ['id_item_im' => 'id']],
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
            'id_disposal_im' => 'Id Disposal Im',
            'id_item_im' => 'Id Item Im',
            'id_disposal_detail' => 'Id Disposal Detail',
            'created_by' => 'Created By',
            'req_good' => 'Req Good',
            'req_not_good' => 'Req Not Good',
            'req_reject' => 'Req Reject',
            'req_good_dismantle' => 'Req Good Dismantle',
            'req_not_good_dismantle' => 'Req Not Good Dismantle',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdDisposalDetail()
    {
        return $this->hasOne(InstructionDisposalDetail::className(), ['id' => 'id_disposal_detail']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdDisposalIm()
    {
        return $this->hasOne(InstructionDisposalIm::className(), ['id' => 'id_disposal_im']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdItemIm()
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
