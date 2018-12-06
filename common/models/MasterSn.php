<?php

namespace common\models;

use Yii;

use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "master_sn".
 *
 * @property integer $id
 * @property string $serial_number
 * @property string $mac_address
 * @property integer $id_warehouse
 * @property string $created_date
 * @property string $last_transaction
 */
class MasterSn extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'master_sn';
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

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_warehouse'], 'integer'],
            [['created_date'], 'safe'],
            [['serial_number', 'mac_address', 'last_transaction'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'serial_number' => 'Serial Number',
            'mac_address' => 'Mac Address',
            'id_warehouse' => 'Id Warehouse',
            'created_date' => 'Created Date',
            'last_transaction' => 'Last Transaction',
        ];
    }
	
	public function beforeSave($isNew){
		if(isset($this->oldAttributes['last_transaction']) && $this->last_transaction != $this->oldAttributes['last_transaction']){
			// The attribute is changed. Do something here...
			$this->prev_last_transaction = $this->oldAttributes['last_transaction'];
			$this->last_condition = $this->oldAttributes['condition'];
			
		}
		
		return parent::beforeSave($isNew);
	}
}
