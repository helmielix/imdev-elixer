<?php

namespace app\models;

use Yii;
use common\models\StatusReference;

/**
 * This is the model class for table "log_ca_iom_and_city".
 *
 * @property integer $idlog
 * @property integer $id
 * @property integer $id_city
 * @property integer $id_ca_iom_area_expansion
 *
 * @property City $idCity
 */
class LogCaIomAndCity extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'log_ca_iom_and_city';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_city', 'id_ca_iom_area_expansion'], 'integer'],
            [['id_city'], 'exist', 'skipOnError' => true, 'targetClass' => City::className(), 'targetAttribute' => ['id_city' => 'id']],
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
            'id_city' => 'Id City',
            'id_ca_iom_area_expansion' => 'Id Ca Iom Area Expansion',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdCity()
    {
        return $this->hasOne(City::className(), ['id' => 'id_city']);
    }
	
	public function getIdCaIomAreaExpansion()
    {
        return $this->hasOne(CaIomAreaExpansion::className(), ['id' => 'id_ca_iom_area_expansion']);
    }
}
