<?php

namespace app\models;

use Yii;
use common\models\StatusReference;

/**
 * This is the model class for table "region".
 *
 * @property integer $id
 * @property string $name
 * @property integer $status
 *
 * @property City[] $cities
 * @property IkoItpWeekly[] $ikoItpWeeklies
 * @property LogIkoItpMonthly[] $logIkoItpMonthlies
 * @property StatusReference $status0
 */
class Region extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'region';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['status'], 'integer'],
            [['name'], 'string', 'max' => 30],
            [['name'], 'unique'],
			[['id'], 'required', 'on'=>'createcity'],
            [['status'], 'exist', 'skipOnError' => true, 'targetClass' => StatusReference::className(), 'targetAttribute' => ['status' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCities()
    {
        return $this->hasMany(City::className(), ['id_region' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIkoItpWeeklies()
    {
        return $this->hasMany(IkoItpWeekly::className(), ['id_region' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLogIkoItpMonthlies()
    {
        return $this->hasMany(LogIkoItpMonthly::className(), ['id_region' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatusRegion()
    {
        return $this->hasOne(StatusReference::className(), ['id' => 'status']);
    }
}
