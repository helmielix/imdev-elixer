<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "email_parameter".
 *
 * @property integer $id
 * @property integer $type_problem
 * @property string $email
 *
 * @property Reference $typeProblem
 */
class EmailParameter extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'email_parameter';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type_problem'], 'integer'],
            [['email'], 'string', 'max' => 60],
            [['type_problem'], 'exist', 'skipOnError' => true, 'targetClass' => Reference::className(), 'targetAttribute' => ['type_problem' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type_problem' => 'Type Problem',
            'email' => 'Email',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTypeProblem()
    {
        return $this->hasOne(Reference::className(), ['id' => 'type_problem']);
    }
}
