<?php

namespace app\models;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use app\models\User;

use Yii;

/**
 * This is the model class for table "os_vendor_spk_detail".
 *
 * @property integer $id
 * @property integer $item_type
 * @property integer $item
 * @property integer $unit
 * @property string $note
 * @property integer $volume
 * @property integer $material_unit_price
 * @property integer $material_sub_price
 * @property integer $service_unit_price
 * @property integer $service_sub_price
 * @property integer $created_by
 * @property string $created_date
 * @property integer $updated_by
 * @property string $updated_date
 *
 * @property Reference $itemType
 * @property Reference $item0
 * @property Reference $unit0
 * @property User $createdBy
 * @property User $updatedBy
 */
class OsVendorPobDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */

	public $subtotalmaterial, $subtotalservice, $subtotal_material_service, $VAT10, $total;



    public static function tableName()
    {
        return 'os_vendor_pob_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[ 'created_by', 'updated_by'], 'integer'],
            [['note'], 'string'],
            [['created_date', 'updated_date','po_number', 'pr_number'], 'safe'],
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
            'note' => 'Note',
			'po_number' => 'PO Number',
            'created_by' => 'Created By',
            'created_date' => 'Created Date',
            'updated_by' => 'Updated By',
            'updated_date' => 'Updated Date',


        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */

    /**
     * @return \yii\db\ActiveQuery
 *
*/
    /**
     * @return \yii\db\ActiveQuery
     */


    public function getStatusReference()
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



	public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_date',
                'updatedAtAttribute' => 'updated_date',
                'value' => new \yii\db\Expression('NOW()'),
            ],
            'blameable' => [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
            ],
        ];
    }
}
