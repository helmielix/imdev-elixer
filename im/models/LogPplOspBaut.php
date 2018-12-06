<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "log_ppl_osp_baut".
 *
 * @property integer $idlog
 * @property integer $id_planning_osp_boq_b
 * @property string $no_baut
 * @property string $date_created
 * @property string $subject_baut
 * @property string $attached_check
 * @property string $attached_doc2
 * @property string $pic_vendor
 * @property string $name_vendor
 * @property integer $created_by
 * @property string $created_date
 * @property integer $updated_by
 * @property string $updated_date
 * @property integer $status_listing
 * @property string $pic_osp
 * @property string $pic_ospm
 * @property string $pic_iko
 * @property string $pic_ppl
 * @property string $revision_remark
 * @property string $upload_real_document
 */
class LogPplOspBaut extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'log_ppl_osp_baut';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_planning_osp_boq_b', 'created_by', 'updated_by', 'status_listing'], 'integer'],
            [['date_created', 'created_date', 'updated_date'], 'safe'],
            [['revision_remark'], 'string'],
            [['no_baut', 'pic_vendor', 'name_vendor', 'pic_osp', 'pic_ospm', 'pic_iko', 'pic_ppl', 'upload_real_document'], 'string', 'max' => 50],
            [['subject_baut'], 'string', 'max' => 100],
            [['attached_check', 'attached_doc2'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idlog' => 'Idlog',
            'id_planning_osp_boq_b' => 'Id Planning Osp Boq B',
            'no_baut' => 'No Baut',
            'date_created' => 'Date Created',
            'subject_baut' => 'Subject Baut',
            'attached_check' => 'Attached Check',
            'attached_doc2' => 'Attached Doc2',
            'pic_vendor' => 'Pic Vendor',
            'name_vendor' => 'Name Vendor',
            'created_by' => 'Created By',
            'created_date' => 'Created Date',
            'updated_by' => 'Updated By',
            'updated_date' => 'Updated Date',
            'status_listing' => 'Status Listing',
            'pic_osp' => 'Pic Osp',
            'pic_ospm' => 'Pic Ospm',
            'pic_iko' => 'Pic Iko',
            'pic_ppl' => 'Pic Ppl',
            'revision_remark' => 'Revision Remark',
            'upload_real_document' => 'Upload Real Document',
        ];
    }
}
