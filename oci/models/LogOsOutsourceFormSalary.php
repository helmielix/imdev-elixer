<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "log_os_outsource_form_salary".
 *
 * @property integer $idlog
 * @property integer $id
 * @property integer $id_city
 * @property integer $id_division
 * @property integer $month
 * @property integer $year
 * @property string $report_finger_print
 * @property integer $created_by
 * @property string $created_date
 * @property integer $updated_by
 * @property string $updated_date
 * @property integer $status_listing
 * @property string $revision_remark
 */
class LogOsOutsourceFormSalary extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'log_os_outsource_form_salary';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_city', 'id_division', 'created_by', 'created_date', 'status_listing'], 'required'],
            [['id', 'id_city', 'id_division', 'month', 'year', 'created_by', 'updated_by', 'status_listing'], 'integer'],
            [['created_date', 'updated_date'], 'safe'],
            [['revision_remark'], 'string'],
            [['report_finger_print'], 'string', 'max' => 255],
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
            'id_division' => 'Id Division',
            'month' => 'Month',
            'year' => 'Year',
            'report_finger_print' => 'Report Finger Print',
            'created_by' => 'Created By',
            'created_date' => 'Created Date',
            'updated_by' => 'Updated By',
            'updated_date' => 'Updated Date',
            'status_listing' => 'Status Listing',
            'revision_remark' => 'Revision Remark',
        ];
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdCity()
    {
        return $this->hasOne(City::className(), ['id' => 'id_city']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdDivision()
    {
        return $this->hasOne(Division::className(), ['id' => 'id_division']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatusReference()
    {
        return $this->hasOne(StatusReference::className(), ['id' => 'status_listing']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOsOutsourceSalaries()
    {
        return $this->hasMany(OsOutsourceSalary::className(), ['id_os_outsource_form_salary' => 'id']);
    }
}
