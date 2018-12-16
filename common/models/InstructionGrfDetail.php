<?php

namespace common\models;

use Yii;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "Instruction_grf_detail".
 *
 * @property integer $id
 * @property integer $id_Instruction_grf
 * @property integer $qty_good
 * @property integer $qty_not_good
 * @property integer $qty_reject
 * @property integer $qty_dismantle
 * @property integer $qty_revocation
 * @property integer $qty_good_rec
 *
 * @property InstructionGrf $idInstructionGrf
 * @property InstructionGrfDetailSn[] $InstructionGrfDetailSns
 */
class InstructionGrfDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'instruction_grf_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_instruction_grf', 'qty_good', 'qty_not_good', 'qty_reject', 'qty_dismantle', 'qty_revocation', 'qty_good_rec', 'qty_good_for_recond','id_item_im'], 'integer'],
            [['id_instruction_grf'], 'exist', 'skipOnError' => true, 'targetClass' => InstructionGrf::className(), 'targetAttribute' => ['id_instruction_grf' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_instruction_grf' => 'Id Instruction Grf',
            'id_item_im' => 'IM Code',
            'created_by' => 'Created By',
            'qty_good' => 'Qty Good',
            'qty_not_good' => 'Qty Noot Good',
            'qty_reject' => 'Qty Reject',
            'qty_dismantle' => 'Qty Dismantle Good',
            'qty_revocation' => 'Qty Dismantle Ng',
            'qty_good_rec' => 'Qty Good Recondtion',
            'qty_good_for_recond' => 'Qty Good For Recondition',
        ];
    }

 public function beforeSave($isNew){
        $modelIm = MasterItemImDetail::find()
                ->andWhere(['id_master_item_im' => $this->id_item_im])
                ->one();

        // check every Request column for changed
        if(isset($this->oldAttributes['qty_good']) && $this->qty_good != $this->oldAttributes['qty_good']){
            // The attribute is changed. Do something here...
            // $modelIm = MasterItemImDetail::findOne($this->id_item_im);

            // add old request to stock
            $modelIm->s_good = $modelIm->s_good + $this->oldAttributes['qty_good'];

            // change stock to the new request
            $modelIm->s_good = $modelIm->s_good - $this->qty_good;

            $modelIm->save();
        }

        if(isset($this->oldAttributes['qty_not_good']) && $this->qty_not_good != $this->oldAttributes['qty_not_good']){
            // The attribute is changed. Do something here...
            // $modelIm = MasterItemImDetail::findOne($this->id_item_im);

            // add old request to stock
            $modelIm->s_not_good = $modelIm->s_not_good + $this->oldAttributes['qty_not_good'];

            // change stock to the new request
            $modelIm->s_not_good = $modelIm->s_not_good - $this->qty_not_good;

            $modelIm->save();
        }

        if(isset($this->oldAttributes['qty_reject']) && $this->qty_reject != $this->oldAttributes['qty_reject']){
            // The attribute is changed. Do something here...
            // $modelIm = MasterItemImDetail::findOne($this->id_item_im);

            // add old request to stock
            $modelIm->s_reject = $modelIm->s_reject + $this->oldAttributes['qty_reject'];

            // change stock to the new request
            $modelIm->s_reject = $modelIm->s_reject - $this->qty_reject;

            $modelIm->save();
        }

        if(isset($this->oldAttributes['qty_dismantle']) && $this->qty_dismantle != $this->oldAttributes['qty_dismantle']){
            // The attribute is changed. Do something here...
            // $modelIm = MasterItemImDetail::findOne($this->id_item_im);

            // add old request to stock
            $modelIm->s_dismantle = $modelIm->s_dismantle + $this->oldAttributes['qty_dismantle'];

            // change stock to the new request
            $modelIm->s_dismantle = $modelIm->s_dismantle - $this->qty_dismantle;

            $modelIm->save();
        }

        if(isset($this->oldAttributes['qty_revocation']) && $this->qty_revocation != $this->oldAttributes['qty_revocation']){
            // The attribute is changed. Do something here...
            // $modelIm = MasterItemImDetail::findOne($this->id_item_im);

            // add old request to stock
            $modelIm->s_revocation = $modelIm->s_revocation + $this->oldAttributes['qty_revocation'];

            // change stock to the new request
            $modelIm->s_revocation = $modelIm->s_revocation - $this->qty_revocation;

            $modelIm->save();
        }

        if(isset($this->oldAttributes['qty_good_rec']) && $this->qty_good_rec != $this->oldAttributes['qty_good_rec']){
            // The attribute is changed. Do something here...
            // $modelIm = MasterItemImDetail::findOne($this->id_item_im);

            // add old request to stock
            $modelIm->s_good_rec = $modelIm->s_good_rec + $this->oldAttributes['qty_good_rec'];

            // change stock to the new request
            $modelIm->s_good_rec = $modelIm->s_good_rec - $this->qty_good_rec;

            $modelIm->save();
        }

        if(isset($this->oldAttributes['qty_good_for_recond']) && $this->qty_good_for_recond != $this->oldAttributes['qty_good_for_recond']){
            // The attribute is changed. Do something here...
            // $modelIm = MasterItemImDetail::findOne($this->id_item_im);

            // add old request to stock
            $modelIm->s_good_for_recond = $modelIm->s_good_for_recond + $this->oldAttributes['qty_good_for_recond'];

            // change stock to the new request
            $modelIm->s_good_for_recond = $modelIm->s_good_for_recond - $this->qty_good_for_recond;

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
    public function getIdMasterItemIm()
    {
        return $this->hasOne(MasterItemIm::className(), ['id' => 'id_item_im']);
    }
    public function getIdInstructionGrf()
    {
        return $this->hasOne(InstructionGrf::className(), ['id' => 'id_instruction_grf']);
    }
    // public function getIdMasterItemImDetail()
    // {
    //     return $this->hasOne(MasterItemImDetail::className(), ['id' => 'id_item_im']);
    // }
     public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    public function getIdMasterItemImDetail()
    {
        return $this->hasOne(MasterItemImDetail::className(), ['id' => 'id_item_im']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInstructionGrfDetailSns()
    {
        return $this->hasMany(InstructionGrfDetailSn::className(), ['id_instruction_grf_detail' => 'id']);
    }
}
