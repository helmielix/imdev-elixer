<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "division".
 *
 * @property integer $id
 * @property string $name
 *
 * @property IkoProblem[] $ikoProblems
 * @property OsOutsourceParameter[] $osOutsourceParameters
 * @property OspProblem[] $ospProblems
 */
class Division extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'division';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 50],
            [['name'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Division',
            'name' => 'Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIkoProblems()
    {
        return $this->hasMany(IkoProblem::className(), ['id_division' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOsOutsourceParameters()
    {
        return $this->hasMany(OsOutsourceParameter::className(), ['id_division' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOspProblems()
    {
        return $this->hasMany(OspProblem::className(), ['id_division' => 'id']);
    }
}
