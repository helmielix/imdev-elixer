<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "user_auth".
 *
 * @property string $username
 * @property string $email
 * @property string $child
 */
class UserAuth extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_auth';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'email'], 'string', 'max' => 255],
            [['child'], 'string', 'max' => 64],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'username' => 'Username',
            'email' => 'Email',
            'child' => 'Child',
        ];
    }
}
