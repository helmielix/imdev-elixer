<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ca_iom_and_city".
 *
 * @property integer $id
 * @property integer $id_city
 * @property integer $id_ca_iom_area_expansion
 *
 * @property CaIomAreaExpansion $idCaIomAreaExpansion
 * @property City $idCity
 */
class CaIomAndCity extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ca_iom_and_city';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_city', 'id_ca_iom_area_expansion'], 'required'],
            [['id_city', 'id_ca_iom_area_expansion'], 'integer'],
            [['id_ca_iom_area_expansion'], 'exist', 'skipOnError' => true, 'targetClass' => CaIomAreaExpansion::className(), 'targetAttribute' => ['id_ca_iom_area_expansion' => 'id']],
            [['id_city'], 'exist', 'skipOnError' => true, 'targetClass' => City::className(), 'targetAttribute' => ['id_city' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_city' => 'Id City',
            'id_ca_iom_area_expansion' => 'Id Ca Iom Area Expansion',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdCaIomAreaExpansion()
    {
        return $this->hasOne(CaIomAreaExpansion::className(), ['id' => 'id_ca_iom_area_expansion']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdCity()
    {
        return $this->hasOne(City::className(), ['id' => 'id_city']);
    }
}
