<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "osp_wo_actual_stdk".
 *
 * @property integer $id_osp_wo
 * @property string $stdk_number
 * @property integer $id
 *
 * @property OspWoActual $idOspWo
 */
class OspWoActualStdk extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'osp_wo_actual_stdk';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_osp_wo'], 'integer'],
            [['stdk_number'], 'string', 'max' => 255],
            [['id_osp_wo'], 'exist', 'skipOnError' => true, 'targetClass' => OspWoActual::className(), 'targetAttribute' => ['id_osp_wo' => 'id_osp_wo']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_osp_wo' => 'Id Osp Wo',
            'stdk_number' => 'Stdk Number',
            'id' => 'ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdOspWo()
    {
        return $this->hasOne(OspWoActual::className(), ['id_osp_wo' => 'id_osp_wo']);
    }
}
