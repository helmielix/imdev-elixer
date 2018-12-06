<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "user_warehouse".
 *
 * @property integer $id
 * @property integer $id_user
 * @property integer $id_warehouse
 */
class UserWarehouse extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_warehouse';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_user', 'id_warehouse'], 'required'],
            [['id_user', 'id_warehouse'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_user' => 'Username',
            'id_warehouse' => 'Nama Warehouse',
        ];
    }
	
	public function getIduser()
    {
        return $this->hasOne(User::className(), ['id' => 'id_user']);
    }
	
	public function getIdwarehouse()
    {
        return $this->hasOne(Warehouse::className(), ['id' => 'id_warehouse']);
    }
}
