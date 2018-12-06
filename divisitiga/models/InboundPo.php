<?php

namespace divisitiga\models;

use Yii;
use common\models\StatusReference;
use common\models\User;
use common\models\OrafinRr;
/**
 * This is the model class for table "inbound_po".
 *
 * @property integer $id
 * @property integer $rr_number
 * @property integer $created_by
 * @property integer $updated_by
 * @property string $created_date
 * @property string $updated_date
 * @property integer $status_listing
 *
 * @property StatusReference $statusListing
 * @property User $createdBy
 * @property User $updatedBy
 * @property InboundPoDetail[] $inboundPoDetails
 */
class InboundPo extends \yii\db\ActiveRecord
{
    public $rr_number, $pr_number, $po_number, $supplier, $rr_date, $waranty;
	
    public static function tableName()
    {
        return 'inbound_po';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[ 'created_by', 'updated_by', 'status_listing'], 'integer'],
            [['created_date', 'updated_date'], 'safe'],
            [['status_listing'], 'exist', 'skipOnError' => true, 'targetClass' => StatusReference::className(), 'targetAttribute' => ['status_listing' => 'id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_by' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            // 'rr_number' => 'Rr Number',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_date' => 'Created Date',
            'updated_date' => 'Updated Date',
            'status_listing' => 'Status Listing',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatusListing()
    {
        return $this->hasOne(StatusReference::className(), ['id' => 'status_listing']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInboundPoDetails()
    {
        return $this->hasMany(InboundPoDetail::className(), ['id_inbound_po' => 'id']);
    }
	
	public function getIdOrafinRr() 
   { 
       return $this->hasOne(OrafinRr::className(), ['id' => 'id_orafin_rr']); 
   }
}
