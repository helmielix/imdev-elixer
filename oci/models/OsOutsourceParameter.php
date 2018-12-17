<?php

namespace app\models;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use app\models\User;


use Yii;

/**
 * This is the model class for table "os_outsource_parameter".
 *
 * @property integer $id
 * @property string $position
 * @property integer $id_division
 * @property integer $work_day
 * @property integer $salary
 * @property integer $allowace_special
 * @property integer $cost_operational
 * @property integer $cost_phone
 * @property integer $allowance_shift
 * @property integer $allowance_pph21
 * @property string $adjusment
 * @property string $bpjs_tk
 * @property string $bpjs_kes
 * @property string $bpjs_jp
 * @property string $man_fee
 * @property string $ppn
 * @property string $pph_23
 * @property integer $created_by
 * @property string $created_date
 * @property integer $updated_by
 * @property string $updated_date
 * @property integer $status_listing
 * @property string $revision_remark
 *
 * @property Division $idDivision
 * @property StatusReference $statusListing
 * @property User $createdBy
 * @property User $updatedBy
 */
class OsOutsourceParameter extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'os_outsource_parameter';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['position', 'id_division', 'work_day','salary','allowance_special','ppn', 'man_fee', 'pph_23', 'status_listing'], 'required'],
			[['id','id_division', 'work_day', 'salary', 'allowance_special', 'cost_operational', 'cost_phone', 'allowance_shift', 'allowance_pph21', 'created_by', 'updated_by', 'status_listing'], 'integer', 'min' => 1],
            [['adjustment', 'bpjs_tk', 'bpjs_kes', 'bpjs_jp', 'man_fee', 'ppn', 'pph_23'], 'number', 'min' => 1],
            [['created_date', 'updated_date'], 'safe'],
            [['revision_remark'], 'string'],
            [['position'], 'string', 'max' => 30],
            [['id_division'], 'exist', 'skipOnError' => true, 'targetClass' => Division::className(), 'targetAttribute' => ['id_division' => 'id']],
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
            'position' => 'Position',
            'id_division' => 'Division',
            'work_day' => 'Work Day ( days )',
            'salary' => 'Salary',
            'allowance_special' => 'Allowance Special',
            'cost_operational' => 'Cost Operational',
            'cost_phone' => 'Cost Phone',
            'allowance_shift' => 'Allowance Shift',
            'allowance_pph21' => 'Allowance Pph21',
            'adjustment' => 'Adjustment',
            'bpjs_tk' => 'Bpjs Tenaga Kerja (%)',
            'bpjs_kes' => 'Bpjs Kesehatan (%)',
            'bpjs_jp' => 'Bpjs Jaminan Pensiun (%)',
            'man_fee' => 'Man Fee (%)',
            'ppn' => 'Ppn (%)',
            'pph_23' => 'Pph 23(%)',
            'created_by' => 'Created By',
            'created_date' => 'Created Date',
            'updated_by' => 'Updated By',
            'updated_date' => 'Updated Date',
            'status_listing' => 'Status Listing',
            'revision_remark' => 'Revision Remark',
			'education' => 'Education',
			'id_city' => 'Working Area',
        ];
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
