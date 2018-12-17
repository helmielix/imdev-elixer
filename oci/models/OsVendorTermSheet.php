<?php

namespace app\models;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use app\models\User;

use Yii;

/**
 * This is the model class for table "os_vendor_term_sheet".
 *
 * @property integer $id
 * @property integer $vendor_name
 * @property string $pic_mkm
 * @property string $pic_vendor
 * @property string $term_sheet
 * @property string $pks
 * @property string $file_attachment
 * @property integer $created_by
 * @property string $created_date
 * @property integer $updated_by
 * @property string $updated_date
 * @property integer $status_listing
 * @property string $revision_remark
 *
 * @property Labor $picMkm
 * @property OsVendorRegistVendor $vendorName
 * @property StatusReference $statusListing
 * @property User $createdBy
 * @property User $updatedBy
 */
class OsVendorTermSheet extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
	 
	 
	 
	public $file,$id_os_vendor_regist, $vendor_name;
	
    public static function tableName()
    {
        return 'os_vendor_term_sheet';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[ 'created_by', 'updated_by', 'status_listing','id_os_vendor_regist'], 'integer'],
            [[ 'pic_vendor', 'pic_mkm', 'status_listing'], 'required'],
            [['created_date', 'updated_date'], 'safe'],
            [['revision_remark', 'vendor_name'], 'string'],
            [['pic_mkm'], 'string', 'max' => 16],
            [['pic_vendor', 'term_sheet', 'pks'], 'string', 'max' => 50],
            [['file_attachment'], 'string', 'max' => 255],
			[['file'], 'file',  'extensions' => 'zip, rar', 'maxSize'=>1024*1024*5],
            [['pic_mkm'], 'exist', 'skipOnError' => true, 'targetClass' => Labor::className(), 'targetAttribute' => ['pic_mkm' => 'nik']],
          //  [['vendor_name'], 'exist', 'skipOnError' => true, 'targetClass' => OsVendorRegistVendor::className(), 'targetAttribute' => //['vendor_name' => 'id']],
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
            
            'pic_mkm' => 'Pic Mkm',
            'pic_vendor' => 'Pic Vendor',
            'term_sheet' => 'Term Sheet',
            'pks' => 'Pks',
            'file_attachment' => 'File',
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
    public function getPicMkm()
    {
        return $this->hasOne(Labor::className(), ['nik' => 'pic_mkm']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdVendorRegistration()
    {
        return $this->hasOne(OsVendorRegistVendor::className(), ['id' => 'id_os_vendor_regist_vendor']);
    }
	
	   public function getReferenceTermSheet()
    {
        return $this->hasOne(Reference::className(), ['id' => 'term_sheet']);
    }
	
	   public function getReferencePks()
    {
        return $this->hasOne(Reference::className(), ['id' => 'pks']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
   
	
	
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
