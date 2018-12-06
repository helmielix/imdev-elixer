<?php

namespace app\models;

use Yii;
use common\models\StatusReference;
/**
 * This is the model class for table "ca_reference".
 *
 * @property integer $id
 * @property string $name
 * @property string $value
 * @property integer $status
 *
 * @property CaBaSurveyReference[] $caBaSurveyReferences
 * @property StatusReference $status0
 */
class CaReference extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ca_reference';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status'], 'integer'],
            [['name'], 'string', 'max' => 50],
            [['value'], 'string', 'max' => 255],
			[['name','value'],'required'],
            [['name', 'value'], 'unique', 'targetAttribute' => ['name', 'value'], 'message' => 'The combination of Name and Value has already been taken.'],
            [['status'], 'exist', 'skipOnError' => true, 'targetClass' => StatusReference::className(), 'targetAttribute' => ['status' => 'id']],
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
            'value' => 'Value',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCaBaSurveyReferences()
    {
        return $this->hasMany(CaBaSurveyReference::className(), ['id_ca_reference' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatusReference()
    {
        return $this->hasOne(StatusReference::className(), ['id' => 'status']);
    }
}
