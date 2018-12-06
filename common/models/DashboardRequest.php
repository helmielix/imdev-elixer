<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
/**
 * This is the model class for table "dashboard_request".
 *
 * @property integer $id
 * @property integer $requestor
 * @property integer $id_module
 * @property string $request_date
 *
 * @property Module $idModule
 * @property User $requestor0
 */
class DashboardRequest extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dashboard_request';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['requestor', 'id_module'], 'required'],
            [['requestor', 'id_module'], 'integer'],
            [['request_date'], 'safe'],
            [['id_module'], 'exist', 'skipOnError' => true, 'targetClass' => Module::className(), 'targetAttribute' => ['id_module' => 'id']],
            [['requestor'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['requestor' => 'id']],
        ];
    }
	
	

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'requestor' => 'Requestor',
            'id_module' => 'Id Module',
            'request_date' => 'Request Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdModule()
    {
        return $this->hasOne(Module::className(), ['id' => 'id_module']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRequestor0()
    {
        return $this->hasOne(User::className(), ['id' => 'requestor']);
    }
}
