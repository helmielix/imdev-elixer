<?php

namespace app\models;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use app\models\User;

use Yii;

/**
 * This is the model class for table "os_vendor_spk".
 *
 * @property integer $id
 * @property integer $id_os_vendor_project_parameter
 * @property integer $currency
 * @property integer $vendor_name
 * @property string $spk_number
 * @property string $spk_date
 * @property integer $created_by
 * @property string $created_date
 * @property integer $updated_by
 * @property string $updated_date
 * @property integer $status_listing
 * @property string $revision_remark
 *
 * @property OsVendorRegistVendor $vendorName
 * @property Reference $projectType
 * @property Reference $currency0
 * @property StatusReference $statusListing
 * @property User $createdBy
 * @property User $updatedBy
 */
class OsVendorPob extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
	public $address, $phone, $email, $fax;

    public static function tableName()
    {
        return 'os_vendor_pob';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_os_vendor_project_parameter',  'vendor_name', 'created_by', 'updated_by', 'status_listing'], 'integer'],
            [['pob_date', 'created_date', 'updated_date'], 'safe'],
            [['vendor_name', 'status_listing','id_os_vendor_project_parameter'], 'required'],
            [['revision_remark'], 'string'],
			[['address', 'phone', 'email', 'fax'], 'safe'],
            [['pob_number'], 'string', 'max' => 50],
            [['vendor_name'], 'exist', 'skipOnError' => true, 'targetClass' => OsVendorRegistVendor::className(), 'targetAttribute' => ['vendor_name' => 'id']],
            [['id_os_vendor_project_parameter'], 'exist', 'skipOnError' => true, 'targetClass' => OsVendorProjectParameter::className(), 'targetAttribute' => ['id_os_vendor_project_parameter' => 'id']],
            // [['currency'], 'exist', 'skipOnError' => true, 'targetClass' => Reference::className(), 'targetAttribute' => ['currency' => 'id']],
            [['status_listing'], 'exist', 'skipOnError' => true, 'targetClass' => StatusReference::className(), 'targetAttribute' => ['status_listing' => 'id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_by' => 'id']],
			// [['id_os_vendor_project_parameter'],'required', 'on'=>'create']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_os_vendor_project_parameter' => 'Project Type',
            // 'currency' => 'Currency',
            'vendor_name' => 'Vendor Name',
            'pob_number' => 'PO Blanket Number',
            'pob_date' => 'PO Blanket Date',
            'created_by' => 'Created By',
            'created_date' => 'Created Date',
            'updated_by' => 'Updated By',
            'updated_date' => 'Updated Date',
            'status_listing' => 'Status Listing',
            'revision_remark' => 'Revision Remark',
			'address' => 'Address',
			'phone' => 'Phone',
			'email' => 'Email',
			'fax'  => 'Fax',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */

	 public function getVendorName()
    {
        return $this->hasOne(OsVendorRegistVendor::className(), ['id' => 'vendor_name']);
    }

    public function getIdVendorRegistVendor()
    {
        return $this->hasOne(OsVendorRegistVendor::className(), ['id' => 'vendor_name']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReferenceProjectType()
    {
        return $this->hasOne(OsVendorProjectParameter::className(), ['id' => 'id_os_vendor_project_parameter']);
    }

    /**
     * @return \yii\db\ActiveQuerys
     */
    // public function getReferenceCurrency()
    // {
        // return $this->hasOne(Reference::className(), ['id' => 'currency']);
    // }

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
