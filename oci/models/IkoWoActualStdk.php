<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "iko_wo_actual_stdk".
 *
 * @property integer $id_iko_wo
 * @property string $stdk_number
 * @property integer $id
 *
 * @property IkoWoActual $idIkoWo
 */
class IkoWoActualStdk extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'iko_wo_actual_stdk';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_iko_wo'], 'integer'],
            [['stdk_number'], 'string', 'max' => 255],
            [['id_iko_wo'], 'exist', 'skipOnError' => true, 'targetClass' => IkoWoActual::className(), 'targetAttribute' => ['id_iko_wo' => 'id_iko_wo']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_iko_wo' => 'Id Iko Wo',
            'stdk_number' => 'Stdk Number',
            'id' => 'ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdIkoWo()
    {
        return $this->hasOne(IkoWoActual::className(), ['id_iko_wo' => 'id_iko_wo']);
    }
}
