<?php

namespace app\models;
use common\models\StatusReference;
use yii\behaviors\TimestampBehavior; 
use yii\behaviors\BlameableBehavior;
use app\models\User;

use Yii;

/**
 * This is the model class for table "govrel_ba_distribution".
 *
 * @property integer $id
 * @property string $permit_date
 * @property string $number_ba
 * @property integer $total_rt
 * @property string $validity_periods_permit
 * @property string $permit_result
 * @property string $note
 * @property string $id_owner
 * @property string $file_bast
 * @property string $free_mnc_result
 * @property string $owner_address
 * @property string $village
 * @property string $created_by
 * @property string $created_date
 * @property string $updated_by
 * @property string $updated_date
 * @property string $status_listing
 * @property string $revision_remark
 * @property integer $id_ca_ba_survey
 * @property string $geom
 * @property string $kmz_file
 * @property integer $id_ca_ba_survey_part
 * @property string $permit_type
 * @property string $status_rollout
 * @property string $date_rollout
 *
 * @property CaBaSurvey $idCaBaSurvey
 * @property Homepass[] $homepasses
 * @property PlanningIkoBasPlan $planningIkoBasPlan
 */
class GovrelBaDistribution extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
	public $file;
    public static function tableName()
    {
        return 'govrel_ba_distribution';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['owner', 'executor_type', 'permit_result','permit_date', 'number_ba','permit_type'], 'required'],
            [['permit_date', 'validity_periods_permit', 'created_date', 'updated_date', 'date_rollout'], 'safe'],
            [['total_rt','status_listing', 'created_by', 'updated_by','executor_type', 'free_mnc_play', 'owner', 'permit_result'], 'integer'],
            [['note', 'revision_remark'], 'string'],
            [['number_ba',  'owner_address'], 'string', 'max' => 50],         
            [['file_bast', 'village'], 'string', 'max' => 255],
            [['number_ba'], 'unique'],
            [['file'], 'file',  'extensions' => 'pdf', 'maxSize'=>1024*1024*5],
            [['file'], 'required', 'on'=> 'create'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'permit_date' => 'Permit Date',
            'number_ba' => 'Number Ba',
            'total_rt' => 'Total Rt',
            'validity_periods_permit' => 'Validity Periods Permit',
            'permit_result' => 'Permit Result',
            'note' => 'Note',
            'owner' => 'Owner',
            'file_bast' => 'File Bast',
            'free_mnc_play' => 'Free Mnc Result',
            'owner_address' => 'Owner Address',
            'village' => 'Village',
            'created_by' => 'Created By',
            'created_date' => 'Created Date',
            'updated_by' => 'Updated By',
            'updated_date' => 'Updated Date',
            'status_listing' => 'Status Listing',
            'revision_remark' => 'Revision Remark',
            'id_ca_ba_survey' => 'Id Ca Ba Survey',
            'geom' => 'Geom',
            'kmz_file' => 'Kmz File',
            'id_ca_ba_survey_part' => 'Id Ca Ba Survey Part',
            'status_rollout' => 'Status Rollout',
            'date_rollout' => 'Date Rollout',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
	 
	
	 
   

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHomepasses()
    {
        return $this->hasMany(Homepass::className(), ['id_govrel_ba_distribution' => 'id_planning_iko_boq_p']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
	  public function getPlanningIkoBoqP()
    {
        return $this->hasOne(PlanningIkoBoqP::className(), ['id_planning_iko_bas_plan' => 'id_planning_iko_boq_p']);
    } 
	 
   
	public function getStatusReference()
    {
    return $this->hasOne(StatusReference::className(), ['id' => 'status_listing']);
    }
	

	public function getReferenceOwner()
    {
    return $this->hasOne(Reference::className(), ['id' => 'owner']);
    }
	
	public function getReferenceFreeMncPlay()
    {
    return $this->hasOne(Reference::className(), ['id' => 'free_mnc_play']);
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
	public function getUserCreatedBy()
    {
    return $this->hasOne(User::className(), ['id' => 'created_by']);
    }
	
	public function getUserUpdatedBy()
    {
    return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }
	
	
}
