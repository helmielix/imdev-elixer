<?php

namespace common\models;

use Yii;

class PoRequisitions extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'PO_REQUISITIONS_INTERFACE_ALL';
    }

    public static function getDb()
    {
        return Yii::$app->get('dborafin');
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


}
