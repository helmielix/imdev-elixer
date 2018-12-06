<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "log_ca_parameter".
 *
 * @property integer $idlog
 * @property integer $id
 * @property string $param_name
 * @property string $param_property
 * @property integer $created_by
 * @property integer $updated_by
 * @property string $created_date
 * @property string $updated_date
 */
class LogCaParameter extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'log_ca_parameter';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'created_by', 'updated_by'], 'integer'],
            [['created_date', 'updated_date'], 'safe'],
            [['param_name', 'param_property'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idlog' => 'Idlog',
            'id' => 'ID',
            'param_name' => 'Param Name',
            'param_property' => 'Param Property',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_date' => 'Created Date',
            'updated_date' => 'Updated Date',
        ];
    }
}
