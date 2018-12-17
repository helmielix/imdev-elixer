<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "vendor_outsource".
 *
 * @property integer $id
 * @property string $description
 * @property integer $status_listing
 *
 * @property OsOutsourcePersonil[] $osOutsourcePersonils
 */
class VendorOutsource extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vendor_outsource';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['description', 'status_listing'], 'required'],
            [['status_listing'], 'integer'],
            [['description'], 'string', 'max' => 100],
            [['description'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'description' => 'Description',
            'status_listing' => 'Status Listing',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOsOutsourcePersonils()
    {
        return $this->hasMany(OsOutsourcePersonil::className(), ['id_vendor' => 'id']);
    }
}
