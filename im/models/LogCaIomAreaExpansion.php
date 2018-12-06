<?php

namespace app\models;

use Yii;
use common\models\StatusReference;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "log_ca_iom_area_expansion".
 *
 * @property integer $idlog
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
 */
class LogCaIomAreaExpansion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'log_ca_iom_area_expansion';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['notes', 'revision_remark'], 'string'],
            [['created_date', 'updated_date'], 'safe'],
            [['id', 'status'], 'integer'],
            [['subject', 'doc_file'], 'string', 'max' => 255],
            [['no_iom_area_exp'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idlog' => 'Idlog',
            'status' => 'Status',
            'subject' => 'Subject',
            'notes' => 'Notes',
            'no_iom_area_exp' => 'No Iom Area Exp',
            'created_by' => 'Created By',
            'created_date' => 'Created Date',
            'updated_by' => 'Updated By',
            'updated_date' => 'Updated Date',
            'revision_remark' => 'Revision Remark',
            'id' => 'ID',
            'doc_file' => 'Doc File',
        ];
    }
	
	 public function getCaIomAndCities()
    {
        return $this->hasMany(CaIomAndCity::className(), ['id_ca_iom_area_expansion' => 'id']);
    }
	
	public function getStatusReference()
	{
		return $this->hasOne(StatusReference::classname(), ['id' => 'status']);
	}
	
	 public function getUpdatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }
}
