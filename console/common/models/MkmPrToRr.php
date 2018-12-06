<?php

namespace common\models;

use Yii;

class MkmPrToRr extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'MKM_PR_TO_RR';
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
