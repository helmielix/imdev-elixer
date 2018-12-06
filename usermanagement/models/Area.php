<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "area".
 *
 * @property string $id
 * @property integer $id_subdistrict
 * @property string $owner
 *
 * @property Subdistrict $idSubdistrict
 * @property CaBaSurvey[] $caBaSurveys
 */
class Area extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'area';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_subdistrict'], 'required'],
            [['id_subdistrict'], 'integer'],
            [['id'], 'string', 'max' => 25],
            [['owner'], 'string', 'max' => 35],
            [['id_subdistrict'], 'exist', 'skipOnError' => true, 'targetClass' => Subdistrict::className(), 'targetAttribute' => ['id_subdistrict' => 'id']],
        ];
    }

    /**
     * @inheritdoc Id Subdistrict
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_subdistrict' => 'Subdistrict',
            'owner' => 'Owner',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdSubdistrict()
    {
        return $this->hasOne(Subdistrict::className(), ['id' => 'id_subdistrict']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCaBaSurveys()
    {
        return $this->hasMany(CaBaSurvey::className(), ['id_area' => 'id']);
    }
}
