<?php

namespace app\models;
//use common\models\StatusReference;
//use common\models\Reference;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use app\models\User;
use app\models\City;


use Yii;

/**
 * This is the model class for table "os_outsource_personil".
 *
 * @property integer $id
 * @property integer $id_vendor
 * @property string $employee_number
 * @property string $birth_place
 * @property string $birth_date
 * @property integer $gender
 * @property integer $religion
 * @property string $address
 * @property integer $marital_status
 * @property string $ktp
 * @property string $phone
 * @property string $no_bpjs_kes
 * @property string $no_bpjs_tk
 * @property string $join_date
 * @property string $contract_start
 * @property string $contract_end
 * @property integer $id_os_outsource_parameter
 * @property string $id_labor
 * @property string $attachment
 * @property string $note
 * @property integer $created_by
 * @property string $created_date
 * @property integer $updated_by
 * @property string $updated_date
 * @property integer $status_listing
 * @property string $revision_remark
 *
 * @property Labor $idLabor
 * @property OsOutsourceParameter $idOsOutsourceParameter
 * @property StatusReference $statusListing
 * @property User $createdBy
 * @property User $updatedBy
 * @property Vendor $idVendor
 */
class OsOutsourcePersonil extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */

	public $file, $file2, $overtime, $pph21, $position, $id_division;

    public static function tableName()
    {
        return 'os_outsource_personil';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['position', 'id_division','id','id_vendor', 'gender', 'religion', 'marital_status', 'id_os_outsource_parameter', 'created_by', 'updated_by', 'status_listing','education', 'id_city'], 'integer'],
            [['id_vendor', 'employee_number', 'birth_place', 'birth_date', 'gender', 'religion', 'address', 'marital_status', 'ktp', 'phone','education',  'join_date', 'contract_start', 'contract_end', 'id_os_outsource_parameter', 'id_labor','id_city', 'status_listing', 'name'], 'required'],
            [['birth_date', 'join_date', 'contract_start', 'contract_end', 'created_date', 'updated_date', 'position', 'id_division'], 'safe'],
			[['birth_date', 'join_date', 'contract_start', 'contract_end'], 'date', 'format' => 'php:Y-m-d'],
            [['note', 'revision_remark'], 'string'],
            [['employee_number', 'ktp', 'id_labor'], 'string', 'max' => 16],
            [['birth_place', 'name'], 'string', 'max' => 50],
            [['address', 'attachment'], 'string', 'max' => 255],
            [['phone'], 'string', 'max' => 15],
			// [['phone'], 'match', 'pattern' => '/^(?:00|\+)[0-9]{4}-?[0-9]{7}$/'],
			[['phone'], 'match', 'pattern' => '/^[0-9\+\-]*$/'],
            [['no_bpjs_kes', 'no_bpjs_tk'], 'string', 'max' => 13],
            [['employee_number'], 'unique'],
			//[['file'], 'file',  'extensions' => 'pdf', 'maxSize'=>1024*1024*5],
			[['file'], 'file',  'extensions' => 'zip,pdf', 'maxSize'=>1024*1024*5],
			[[], 'required', 'on' => 'create'],
            [['id_labor'], 'exist', 'skipOnError' => true, 'targetClass' => Labor::className(), 'targetAttribute' => ['id_labor' => 'nik']],
            [['id_os_outsource_parameter'], 'exist', 'skipOnError' => true, 'targetClass' => OsOutsourceParameter::className(), 'targetAttribute' => ['id_os_outsource_parameter' => 'id']],
            [['status_listing'], 'exist', 'skipOnError' => true, 'targetClass' => StatusReference::className(), 'targetAttribute' => ['status_listing' => 'id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_by' => 'id']],
         //   [['id_vendor'], 'exist', 'skipOnError' => true, 'targetClass' => Vendor::className(), 'targetAttribute' => ['id_vendor' => 'id']],
			[['overtime', 'pph21'], 'safe'],
			[['pph21'],'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_vendor' => 'Vendor',
            'employee_number' => 'Employee Number',
            'birth_place' => 'Birth Place',
            'birth_date' => 'Birth Date',
            'gender' => 'Gender',
            'religion' => 'Religion',
            'address' => 'Address',
            'marital_status' => 'Marital Status',
            'ktp' => 'KTP',
            'phone' => 'Phone',
            'no_bpjs_kes' => 'No Bpjs Kesehatan',
            'no_bpjs_tk' => 'No Bpjs Tenaga Kerja',
            'join_date' => 'Join Date',
            'contract_start' => 'Contract Start',
            'contract_end' => 'Contract End',
            'id_os_outsource_parameter' => 'Id OS Outsource Parameter',
            'id_labor' => 'Head of Personil',
            'attachment' => 'Attachment',
            'note' => 'Note',
            'created_by' => 'Created By',
            'created_date' => 'Created Date',
            'updated_by' => 'Updated By',
            'updated_date' => 'Updated Date',
            'status_listing' => 'Status Listing',
            'revision_remark' => 'Revision Remark',
			'id_city' => 'City',
			'overtime' => 'Overtime',
			'pph21' => 'PPH 21',
			'position' => 'Position',
			'id_division' => 'Division',
			'file2' => 'File Upload',

        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdLabor()
    {
        return $this->hasOne(Labor::className(), ['nik' => 'id_labor']);
    }

	public function getIdOspTeamWoActual()
    {
        return $this->hasMany(OspTeamWoActual::className(), ['nik' => 'employee_number']);

    }

	public function getIdIkoTeamWoActual()
    {
        return $this->hasMany(IkoTeamWoActual::className(), ['nik' => 'employee_number']);

    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdOsOutsourceParameter()
    {
        return $this->hasOne(OsOutsourceParameter::className(), ['id' => 'id_os_outsource_parameter']);
    }

	 public function getIdOsOutsourceSalary()
    {
        return $this->hasOne(OsOutsourceSalary::className(), ['id_os_outsource_personil' => 'id']);
    }

	public function getReferenceVendor()
    {
        return $this->hasOne(VendorOutsource::className(), ['id' => 'id_vendor']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatusReference()
    {
        return $this->hasOne(StatusReference::className(), ['id' => 'status_listing']);
    }

	public function getReferenceGender()
    {
        return $this->hasOne(Reference::className(), ['id' => 'gender']);
    }

	public function getReferenceReligion()
    {
        return $this->hasOne(Reference::className(), ['id' => 'religion']);
    }

	public function getReferenceMaritalStatus()
    {
        return $this->hasOne(Reference::className(), ['id' => 'marital_status']);
    }

	public function getReferenceEducation()
    {
        return $this->hasOne(Reference::className(), ['id' => 'education']);
    }

	public function getIdCity()
    {
        return $this->hasOne(City::className(), ['id' => 'id_city']);
    }

	public function getIdDivision()
    {
        return $this->hasOne(Division::className(), ['id' => 'id_division']);
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
    public function getIdVendor()
    {
        return $this->hasOne(Vendor::className(), ['id' => 'id_vendor']);
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
