<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

class PoRequisitionsForo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'po_requisitions';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [

        ];
    }
	
	public function behaviors()
    {
    	return [
    		'timestamp' => [
    			'class' => TimestampBehavior::className(),
    			'createdAtAttribute' => 'created_date',
    			// 'updatedAtAttribute' => 'updated_date',
    			'value' => new \yii\db\Expression('NOW()'),
    		],
    		'blameable' => [
    			'class' => BlameableBehavior::className(),
    			'createdByAttribute' => 'created_by',
    			// 'updatedByAttribute' => 'updated_by',
    		],
    	];
    }


}
