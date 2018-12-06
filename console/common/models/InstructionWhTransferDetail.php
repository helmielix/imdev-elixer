<?php

namespace common\models;

use Yii;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "instruction_wh_transfer_detail".
 *
 * @property integer $id
 * @property integer $id_instruction_wh
 * @property integer $id_item_im
 * @property integer $created_by
 * @property integer $req_good
 * @property integer $req_not_good
 * @property integer $req_reject
 *
 * @property InstructionWhTransfer $idInstructionWh
 * @property ItemIm $idItemIm
 * @property User $createdBy
 */
class InstructionWhTransferDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
	public $name, $brand, $warna, $sn_type;
	public $rem_good, $rem_not_good, $rem_reject, $rem_good_dismantle, $rem_not_good_dismantle;
    public static function tableName()
    {
        return 'instruction_wh_transfer_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_instruction_wh', 'id_item_im'], 'required'],
            [['id_instruction_wh', 'id_item_im', 'created_by', 'req_good', 'req_not_good', 'req_reject', 'req_good_dismantle', 'req_not_good_dismantle'], 'integer'],
            [['rem_good', 'rem_not_good', 'rem_reject', 'rem_good_dismantle', 'rem_not_good_dismantle'], 'integer'],
            [['req_good', 'req_not_good', 'req_reject', 'req_good_dismantle', 'req_not_good_dismantle'], 'required', 'on' => 'updatedetail'],
            [['id_instruction_wh'], 'exist', 'skipOnError' => true, 'targetClass' => InstructionWhTransfer::className(), 'targetAttribute' => ['id_instruction_wh' => 'id']],
            // [['id_item_im'], 'exist', 'skipOnError' => true, 'targetClass' => ItemIm::className(), 'targetAttribute' => ['id_item_im' => 'id']],
            // [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
			[['req_good'], 'compare', 'operator' => '<=', 'compareAttribute' => 'rem_good', 'type' => 'number', 'on' => 'updatedetail'],
			[['req_not_good'], 'compare', 'operator' => '<=', 'compareAttribute' => 'rem_not_good', 'type' => 'number', 'on' => 'updatedetail'],
			[['req_reject'], 'compare', 'operator' => '<=', 'compareAttribute' => 'rem_reject', 'type' => 'number', 'on' => 'updatedetail'],
			[['req_good_dismantle'], 'compare', 'operator' => '<=', 'compareAttribute' => 'rem_good_dismantle', 'type' => 'number', 'on' => 'updatedetail'],
			[['req_not_good_dismantle'], 'compare', 'operator' => '<=', 'compareAttribute' => 'rem_not_good_dismantle', 'type' => 'number', 'on' => 'updatedetail'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_instruction_wh' => 'Id Instruction Wh',
            'id_item_im' => 'IM Code',
            'created_by' => 'Created By',
            'req_good' => 'Request Good',
            'req_not_good' => 'Request Not Good',
            'req_reject' => 'Request Reject',
			'req_good_dismantle' => 'Request Good Dismantle',
            'req_not_good_dismantle' => 'Request Not Good Dismantle',
			'sn_type' => 'SN / Non SN',
        ];
    }

	public function beforeSave($isNew){
		$modelIm = MasterItemImDetail::find()
				->andWhere(['id_master_item_im' => $this->id_item_im])
				->andWhere(['id_warehouse' => $this->idInstructionWh->wh_origin])
				->one();

		// check every Request column for changed
		if(isset($this->oldAttributes['req_good']) && $this->req_good != $this->oldAttributes['req_good']){
			// The attribute is changed. Do something here...
			// $modelIm = MasterItemImDetail::findOne($this->id_item_im);

			// add old request to stock
			$modelIm->s_good = $modelIm->s_good + $this->oldAttributes['req_good'];

			// change stock to the new request
			$modelIm->s_good = $modelIm->s_good - $this->req_good;

			$modelIm->save();
		}

		if(isset($this->oldAttributes['req_not_good']) && $this->req_not_good != $this->oldAttributes['req_not_good']){
			// The attribute is changed. Do something here...
			// $modelIm = MasterItemImDetail::findOne($this->id_item_im);

			// add old request to stock
			$modelIm->s_not_good = $modelIm->s_not_good + $this->oldAttributes['req_not_good'];

			// change stock to the new request
			$modelIm->s_not_good = $modelIm->s_not_good - $this->req_not_good;

			$modelIm->save();
		}

		if(isset($this->oldAttributes['req_reject']) && $this->req_reject != $this->oldAttributes['req_reject']){
			// The attribute is changed. Do something here...
			// $modelIm = MasterItemImDetail::findOne($this->id_item_im);

			// add old request to stock
			$modelIm->s_reject = $modelIm->s_reject + $this->oldAttributes['req_reject'];

			// change stock to the new request
			$modelIm->s_reject = $modelIm->s_reject - $this->req_reject;

			$modelIm->save();
		}

		if(isset($this->oldAttributes['req_good_dismantle']) && $this->req_good_dismantle != $this->oldAttributes['req_good_dismantle']){
			// The attribute is changed. Do something here...
			// $modelIm = MasterItemImDetail::findOne($this->id_item_im);

			// add old request to stock
			$modelIm->s_good_dismantle = $modelIm->s_good_dismantle + $this->oldAttributes['req_good_dismantle'];

			// change stock to the new request
			$modelIm->s_good_dismantle = $modelIm->s_good_dismantle - $this->req_good_dismantle;

			$modelIm->save();
		}

		if(isset($this->oldAttributes['req_not_good_dismantle']) && $this->req_not_good_dismantle != $this->oldAttributes['req_not_good_dismantle']){
			// The attribute is changed. Do something here...
			// $modelIm = MasterItemImDetail::findOne($this->id_item_im);

			// add old request to stock
			$modelIm->s_not_good_dismantle = $modelIm->s_not_good_dismantle + $this->oldAttributes['req_not_good_dismantle'];

			// change stock to the new request
			$modelIm->s_not_good_dismantle = $modelIm->s_not_good_dismantle - $this->req_not_good_dismantle;

			$modelIm->save();
		}


		return parent::beforeSave($isNew);
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
        return $this->hasOne(InstructionWhTransfer::className(), ['id' => 'id_instruction_wh']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    // public function getIdMasterItemImDetail()
    // {
    //     return $this->hasOne(MasterItemImDetail::className(), ['id' => 'id_item_im']);
    // }

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
