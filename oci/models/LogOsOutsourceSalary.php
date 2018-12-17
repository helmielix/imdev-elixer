<?php

namespace app\models;
use common\models\StatusReference;
use yii\behaviors\TimestampBehavior; 
use yii\behaviors\BlameableBehavior;
use app\models\User;

use Yii;

/**
 * This is the model class for table "log_os_outsource_salary".
 *
 * @property integer $id
 * @property integer $month
 * @property integer $year
 * @property integer $id_os_outsource_personil
 * @property string $report_finger_print
 * @property integer $overtime
 * @property integer $created_by
 * @property string $created_date
 * @property integer $updated_by
 * @property string $updated_date
 * @property integer $status_listing
 * @property string $revision_remark
 *
 * @property OsOutsourcePersonil $idOsOutsourcePersonil
 * @property Reference $month0
 * @property Reference $year0
 * @property StatusReference $statusListing
 * @property User $createdBy
 * @property User $updatedBy
 */
class LogOsOutsourceSalary extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
	 
	public $file, $total_allowance_special, $count_man_fee, $count_ppn, $count_pph23, $id_division, $id_city; 
	
    public static function tableName()
    {
        return 'log_os_outsource_salary';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
           // [[ 'id_division', 'id_city', 'month'], 'required'],
            [['month', 'year', 'id_os_outsource_personil', 'overtime', 'created_by', 'updated_by', 'status_listing', 'id_division', 'id_city'], 'integer'],
            [['created_date', 'updated_date'], 'safe'],
			[[ 'total_invoice', 'total','pph21', 'total_gaji'], 'double'],
            [['revision_remark'], 'string'],
			[['file'], 'file',  'extensions' => 'xls, xlsx, xlsb', 'maxSize'=>1024*1024*5],
			[['file'], 'required', 'on' => 'create' ],
            [['report_finger_print'], 'string', 'max' => 255],
            [['month', 'year', 'id_os_outsource_personil'], 'unique', 'targetAttribute' => ['month', 'year', 'id_os_outsource_personil'], 'message' => 'The combination of Month, Year and Id Os Outsource Personil has already been taken.'],
            [['id_os_outsource_personil'], 'exist', 'skipOnError' => true, 'targetClass' => OsOutsourcePersonil::className(), 'targetAttribute' => ['id_os_outsource_personil' => 'id']],
            [['month'], 'exist', 'skipOnError' => true, 'targetClass' => Reference::className(), 'targetAttribute' => ['month' => 'id']],
            [['year'], 'exist', 'skipOnError' => true, 'targetClass' => Reference::className(), 'targetAttribute' => ['year' => 'id']],
            [['status_listing'], 'exist', 'skipOnError' => true, 'targetClass' => StatusReference::className(), 'targetAttribute' => ['status_listing' => 'id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_by' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'month' => 'Month',
            'year' => 'Year',
            'id_os_outsource_personil' => 'Id Os Outsource Personil',
            'report_finger_print' => 'Report Finger Print',
            'overtime' => 'Overtime',
            'created_by' => 'Created By',
            'created_date' => 'Created Date',
            'updated_by' => 'Updated By',
            'updated_date' => 'Updated Date',
            'status_listing' => 'Status Listing',
            'revision_remark' => 'Revision Remark',
			'file' => 'Report Finger Print',
			'id_division' => 'Division',
			'id_city' => 'City',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdOsOutsourcePersonil()
    {
        return $this->hasOne(OsOutsourcePersonil::className(), ['id' => 'id_os_outsource_personil']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReferenceMonth()
    {
        return $this->hasOne(Reference::className(), ['id' => 'month']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getYear0()
    {
        return $this->hasOne(Reference::className(), ['id' => 'year']);
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
	
	public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_date',
                'updatedAtAttribute' => 'updated_date',
                'value' => new \yii\db\Expression('NOW()'),
            ],            
            'blameable' => [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
            ],
        ];
    }
}
