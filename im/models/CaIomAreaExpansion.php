<?php

namespace app\models;

use Yii;
use common\models\StatusReference;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
/**
 * This is the model class for table "ca_iom_area_expansion".
 *
 * @property string $status
 * @property string $subject
 * @property string $notes
 * @property string $no_iom_area_exp
 * @property string $created_by
 * @property string $created_date
 * @property string $updated_by
 * @property string $updated_date
 * @property string $revision_remark
 * @property integer $id
 * @property string $doc_file
 *
 * @property CaIomAndCity[] $caIomAndCities
 */
class CaIomAreaExpansion extends \yii\db\ActiveRecord
{
    public $file;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ca_iom_area_expansion';
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

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['notes', 'revision_remark'], 'string'],
            [['no_iom_area_exp', 'created_by', 'created_date', 'doc_file'], 'required'],
            [['created_date', 'updated_date'], 'safe'],
            [['status'], 'integer'],
            [['subject', 'doc_file'], 'string', 'max' => 255],
            [['no_iom_area_exp'], 'string', 'max' => 50],
            [['no_iom_area_exp'], 'unique'],
            [['file'], 'file',  'extensions' => 'jpg,pdf', 'maxSize'=>1024*1024*5],
			[['file'], 'required',  'on' => 'create'],
			[['revision_remark'], 'required',  'on' => 'revise'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'status' => 'Status',
            'subject' => 'Subject',
            'notes' => 'Notes',
            'no_iom_area_exp' => 'No IOM Area Expansion',
            'created_by' => 'Created By',
            'created_date' => 'Created Date',
            'updated_by' => 'Updated By',
            'updated_date' => 'Updated Date',
            'revision_remark' => 'Revision Remark',
            'id' => 'ID',
            'doc_file' => 'Doc File',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCaIomAndCities()
    {
        return $this->hasMany(CaIomAndCity::className(), ['id_ca_iom_area_expansion' => 'id']);
    }
	
	public function getStatusReference()
	{
		return $this->hasOne(StatusReference::classname(), ['id' => 'status']);
	}
}
