<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "iko_bas_plan".
 *
 * @property integer $id
 * @property string $survey_date
 * @property string $work_type
 * @property string $bas_number
 * @property string $pic1
 * @property string $position1
 * @property string $pic2
 * @property string $position2
 * @property string $note
 * @property string $uploaded_file
 * @property string $created_by
 * @property string $updated_by
 * @property string $created_date
 * @property string $updated_date
 * @property string $status_listing
 * @property string $revision_remark
 * @property string $geom
 * @property integer $id_govrel_ba_distribution
 * @property integer $id_govrel_ba_distribution_part
 * @property string $project
 * @property string $project_type
 *
 * @property Homepass[] $homepasses
 * @property IkoApd $ikoApd
 * @property IkoBasImplementation $ikoBasImplementation
 * @property GovrelBaDistribution $idGovrelBaDistribution
 * @property IkoBaut $ikoBaut
 * @property IkoBoqB $ikoBoqB
 * @property IkoBoqP $ikoBoqP
 * @property IkoItpArea[] $ikoItpAreas
 */
class IkoBasPlan extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'iko_bas_plan';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['survey_date', 'work_type', 'bas_number', 'pic1', 'position1', 'created_by', 'created_date', 'status_listing'], 'required'],
            [['survey_date', 'created_date', 'updated_date'], 'safe'],
            [['note', 'revision_remark', 'geom'], 'string'],
            [['id_govrel_ba_distribution', 'id_govrel_ba_distribution_part'], 'integer'],
            [['work_type', 'bas_number', 'pic1', 'pic2', 'created_by', 'updated_by', 'project', 'project_type'], 'string', 'max' => 50],
            [['position1', 'position2'], 'string', 'max' => 20],
            [['uploaded_file'], 'string', 'max' => 255],
            [['status_listing'], 'string', 'max' => 15],
            [['bas_number'], 'unique'],
            [['id_govrel_ba_distribution'], 'exist', 'skipOnError' => true, 'targetClass' => GovrelBaDistribution::className(), 'targetAttribute' => ['id_govrel_ba_distribution' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'survey_date' => 'Survey Date',
            'work_type' => 'Work Type',
            'bas_number' => 'Bas Number',
            'pic1' => 'Pic1',
            'position1' => 'Position1',
            'pic2' => 'Pic2',
            'position2' => 'Position2',
            'note' => 'Note',
            'uploaded_file' => 'Uploaded File',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_date' => 'Created Date',
            'updated_date' => 'Updated Date',
            'status_listing' => 'Status Listing',
            'revision_remark' => 'Revision Remark',
            'geom' => 'Geom',
            'id_govrel_ba_distribution' => 'Id Govrel Ba Distribution',
            'id_govrel_ba_distribution_part' => 'Id Govrel Ba Distribution Part',
            'project' => 'Project',
            'project_type' => 'Project Type',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHomepasses()
    {
        return $this->hasMany(Homepass::className(), ['id_iko_bas_plan' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIkoApd()
    {
        return $this->hasOne(IkoApd::className(), ['id_iko_bas_plan' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIkoBasImplementation()
    {
        return $this->hasOne(IkoBasImplementation::className(), ['id_iko_bas_plan' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdGovrelBaDistribution()
    {
        return $this->hasOne(GovrelBaDistribution::className(), ['id' => 'id_govrel_ba_distribution']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIkoBaut()
    {
        return $this->hasOne(IkoBaut::className(), ['id_iko_bas_plan' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIkoBoqB()
    {
        return $this->hasOne(IkoBoqB::className(), ['id_iko_bas_plan' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIkoBoqP()
    {
        return $this->hasOne(IkoBoqP::className(), ['id_iko_bas_plan' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIkoItpAreas()
    {
        return $this->hasMany(IkoItpArea::className(), ['id_iko_bas_plan' => 'id']);
    }
}
