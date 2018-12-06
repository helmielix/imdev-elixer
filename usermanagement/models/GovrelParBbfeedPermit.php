<?php

namespace app\models;
use common\models\StatusReference;
use yii\behaviors\TimestampBehavior; 
use yii\behaviors\BlameableBehavior;
use app\models\User;

use Yii;

/**
 * This is the model class for table "govrel_par_bbfeed_permit".
 *
 * @property integer $id
 * @property string $name
 */
class GovrelParBbfeedPermit extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'govrel_par_bbfeed_permit';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
		    [['name'], 'required'],
            [['id','status_listing','status_par','created_by','updated_by'], 'integer'],
            [['name'], 'string', 'max' => 100],
		    [['revision_remark'], 'string'],
            [['craeted_date', 'updated_date'], 'safe'],   			
			
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
			'status_listing' => 'Status Listing',
			'status_par' => 'Status Parameter',
			'revision_remark' => 'Remark',
        ];
    }
	
	
	public function getStatusReference()
   {
    return $this->hasOne(StatusReference::className(), ['id' => 'status_listing']);
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
	
	public function getUserCreatedBy()
    {
    return $this->hasOne(User::className(), ['id' => 'created_by']);
    }
	
	public function getUserUpdatedBy()
    {
    return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }
	
	public function getStatusReferenceStatusParameter()
   {
    return $this->hasOne(StatusReference::className(), ['id' => 'status_par']);
    }
	
}
