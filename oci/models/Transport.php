<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "transport".
 *
 * @property integer $id
 * @property string $type
 * @property string $plat_number
 *
 * @property IkoTransportWo[] $ikoTransportWos
 * @property OspTransportWo[] $ospTransportWos
 */
class Transport extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'transport';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'plat_number'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
            'plat_number' => 'Plat Number',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIkoTransportWos()
    {
        return $this->hasMany(IkoTransportWo::className(), ['id_transport' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOspTransportWos()
    {
        return $this->hasMany(OspTransportWo::className(), ['id_transport' => 'id']);
    }
}
