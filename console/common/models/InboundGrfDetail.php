<?php

namespace common\models;

use Yii;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "inbound_grf_detail".
 *
 * @property integer $id
 * @property integer $id_inbound_grf
 * @property integer $qty_good
 * @property integer $qty_noot_good
 * @property integer $qty_reject
 * @property integer $qty_dismantle_good
 * @property integer $qty_dismantle_ng
 * @property integer $qty_good_rec
 *
 * @property InboundGrf $idInboundGrf
 * @property InboundGrfDetailSn[] $inboundGrfDetailSns
 */
class InboundGrfDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'inbound_grf_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_inbound_grf', 'qty_good', 'qty_noot_good', 'qty_reject', 'qty_dismantle_good', 'qty_dismantle_ng', 'qty_good_rec','id_item_im'], 'integer'],
            [['id_inbound_grf'], 'exist', 'skipOnError' => true, 'targetClass' => InboundGrf::className(), 'targetAttribute' => ['id_inbound_grf' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_inbound_grf' => 'Id Inbound Grf',
            'id_item_im' => 'IM Code',
            'created_by' => 'Created By',
            'qty_good' => 'Qty Good',
            'qty_noot_good' => 'Qty Noot Good',
            'qty_reject' => 'Qty Reject',
            'qty_dismantle_good' => 'Qty Dismantle Good',
            'qty_dismantle_ng' => 'Qty Dismantle Ng',
            'qty_good_rec' => 'Qty Good Rec',
        ];
    }

    public function beforeSave($isNew){
        // check every Request column for changed
        if(isset($this->oldAttributes['qty_good']) && $this->qty_good != $this->oldAttributes['qty_good']){
            // The attribute is changed. Do something here...
            $modelIm = MasterItemImDetail::findOne($this->id_item_im);
            
            // add old request to stock
            $modelIm->s_good = $modelIm->s_good + $this->oldAttributes['qty_good'];
            
            // change stock to the new request
            $modelIm->s_good = $modelIm->s_good - $this->qty_good;
            
            $modelIm->save();
        }
        
        if(isset($this->oldAttributes['qty_noot_good']) && $this->qty_noot_good != $this->oldAttributes['qty_noot_good']){
            // The attribute is changed. Do something here...
            $modelIm = MasterItemImDetail::findOne($this->id_item_im);
            
            // add old request to stock
            $modelIm->s_not_good = $modelIm->s_not_good + $this->oldAttributes['qty_noot_good'];
            
            // change stock to the new request
            $modelIm->s_not_good = $modelIm->s_not_good - $this->qty_noot_good;
            
            $modelIm->save();
        }
        
        if(isset($this->oldAttributes['qty_reject']) && $this->qty_reject != $this->oldAttributes['qty_reject']){
            // The attribute is changed. Do something here...
            $modelIm = MasterItemImDetail::findOne($this->id_item_im);
            
            // add old request to stock
            $modelIm->s_reject = $modelIm->s_reject + $this->oldAttributes['qty_reject'];
            
            // change stock to the new request
            $modelIm->s_reject = $modelIm->s_reject - $this->qty_reject;
            
            $modelIm->save();
        }
        
        if(isset($this->oldAttributes['qty_dismantle_good']) && $this->qty_dismantle_good != $this->oldAttributes['qty_dismantle_good']){
            // The attribute is changed. Do something here...
            $modelIm = MasterItemImDetail::findOne($this->id_item_im);
            
            // add old request to stock
            $modelIm->s_good_dismantle = $modelIm->s_good_dismantle + $this->oldAttributes['qty_dismantle_good'];
            
            // change stock to the new request
            $modelIm->s_good_dismantle = $modelIm->s_good_dismantle - $this->qty_dismantle_good;
            
            $modelIm->save();
        }
        
        if(isset($this->oldAttributes['qty_dismantle_ng']) && $this->qty_dismantle_ng != $this->oldAttributes['qty_dismantle_ng']){
            // The attribute is changed. Do something here...
            $modelIm = MasterItemImDetail::findOne($this->id_item_im);
            
            // add old request to stock
            $modelIm->s_not_good_dismantle = $modelIm->s_not_good_dismantle + $this->oldAttributes['qty_dismantle_ng'];
            
            // change stock to the new request
            $modelIm->s_not_good_dismantle = $modelIm->s_not_good_dismantle - $this->qty_dismantle_ng;
            
            $modelIm->save();
        }
        if(isset($this->oldAttributes['qty_good_rec']) && $this->qty_good_rec != $this->oldAttributes['qty_good_rec']){
            // The attribute is changed. Do something here...
            $modelIm = MasterItemImDetail::findOne($this->id_item_im);
            
            // add old request to stock
            $modelIm->s_good_rec = $modelIm->s_good_rec + $this->oldAttributes['qty_good_rec'];
            
            // change stock to the new request
            $modelIm->s_good_rec = $modelIm->s_good_rec - $this->qty_good_rec;
            
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
    public function getIdInboundGrf()
    {
        return $this->hasOne(InboundGrf::className(), ['id' => 'id_inbound_grf']);
    }
    public function getIdMasterItemImDetail()
    {
        return $this->hasOne(MasterItemImDetail::className(), ['id' => 'id_item_im']);
    }
     public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInboundGrfDetailSns()
    {
        return $this->hasMany(InboundGrfDetailSn::className(), ['id_inbound_grf_detail' => 'id']);
    }
}
