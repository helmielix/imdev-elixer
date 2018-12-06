<?php

namespace setting\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use common\models\User;

/**
 * This is the model class for table "master_item_im".
 *
 * @property integer $id
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $status
 * @property string $name
 * @property string $brand
 * @property string $warna
 * @property string $created_date
 * @property string $updated_date
 * @property string $im_code
 * @property string $orafin_code
 */
class MasterItemIm extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $action;
    public static function tableName()
    {
        return 'master_item_im';
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
            [['status', 'name', 'brand', 'warna', 'im_code'], 'required'],
            [['status','sn_type'], 'integer'],
            [['created_date', 'updated_date'], 'safe'],
            [['name', 'brand', 'warna', 'im_code', 'orafin_code'], 'string', 'max' => 255],
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
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'status' => 'Status',
            'name' => 'Name',
            'brand' => 'Brand',
            'warna' => 'Warna',
            'created_date' => 'Created Date',
            'updated_date' => 'Updated Date',
            'im_code' => 'Im Code',
            'orafin_code' => 'Orafin Code',
        ];
    }
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
}
