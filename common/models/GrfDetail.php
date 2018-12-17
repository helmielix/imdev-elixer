<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "grf_detail".
 *
 * @property integer $id
 * @property integer $id_grf
 * @property string $orafin_code
 * @property integer $qty_request
 *
 * @property Grf $idGrf
 */
class GrfDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $name, $grouping, $im_code, $brand, $warna, $referenceSn, $type, $qty_good,
            $qty_not_good, $qty_reject, $qty_dismantle, $qty_revocation, $qty_good_for_recond,
            $qty_good_rec, $sn_type, $status_listing, $description, $id_instruction_grf, $referenceBrand, $item_code, $qty_dismantle_good,$qty_dismantle_ng;
    public static function tableName()
    {
        return 'grf_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_grf', 'qty_request', 'status_return'], 'integer'],
            [['name', 'grouping','item_desc'],'safe'],
            [['orafin_code'], 'string', 'max' => 255],
            [['id_grf'], 'exist', 'skipOnError' => true, 'targetClass' => Grf::className(), 'targetAttribute' => ['id_grf' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_grf' => 'Id Grf',
            'orafin_code' => 'Orafin Code',
            'qty_request' => 'Qty Request',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdGrf()
    {
        return $this->hasOne(Grf::className(), ['id' => 'id_grf']);
    }
	
	public function getIdOrafinCode(){
        return $this->hasOne(MasterItemIm::className(), ['orafin_code' => 'orafin_code']);
    }
    public function getIdItemCode(){
		return $this->hasOne(MkmMasterItem::className(), ['item_code' => 'orafin_code']);
	}

    public function getIdMasterItemImDetail()
    {
        return $this->hasOne(MasterItemImDetail::className(), ['id' => 'id_item_im']);
    }
     public function getStatusReturn()
    {
        return $this->hasOne(StatusReference::className(), ['id' => 'status_return']);
    }
}
