<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "potentialca_withgeom".
 *
 * @property integer $id
 * @property integer $id_map
 * @property string $location
 * @property string $nama_area
 * @property string $hari_survey
 * @property string $tanggal_survey
 * @property string $owner_type
 * @property string $kelurahan
 * @property string $kecamatan
 * @property integer $id_iom_city
 * @property string $regional
 * @property double $coordinat_x
 * @property double $coordinat_y
 * @property integer $home_pass
 * @property integer $prioritas
 * @property string $jenis_properti_area
 * @property string $klasifikasi_jenis_rumah
 * @property double $rata_rata_okupansi
 * @property string $mayoritas_penghuni_memiliki
 * @property string $metode_pembangunan
 * @property string $akses_penjualan
 * @property string $kompetitor
 * @property string $pengguna_dth
 * @property string $pic
 * @property string $note
 * @property string $permit_plan_start
 * @property string $permit_plan_end
 * @property string $permit_actual_start
 * @property string $permit_actual_end
 * @property string $executor
 * @property string $special_req
 * @property string $special_req_sales
 * @property string $download_file
 * @property string $create_by
 * @property string $create_date
 * @property string $special_by
 * @property string $special_date
 * @property string $approve_by
 * @property string $approve_date
 * @property string $input_area_by
 * @property string $input_area_date
 * @property integer $home_pass_potential
 * @property string $recommendation
 * @property string $team_leader
 * @property integer $id_survey_batch
 * @property string $id_area
 * @property string $status_survey
 * @property string $catatan_revisi
 * @property integer $gid
 * @property string $geom
 * @property string $coordinates
 */
class PotentialcaWithgeom extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'potentialca_withgeom';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_map', 'id_iom_city', 'home_pass', 'prioritas', 'home_pass_potential', 'id_survey_batch', 'gid'], 'integer'],
            [['hari_survey', 'jenis_properti_area', 'klasifikasi_jenis_rumah', 'mayoritas_penghuni_memiliki', 'metode_pembangunan', 'akses_penjualan', 'kompetitor', 'pengguna_dth', 'note', 'executor', 'id_area', 'status_survey', 'catatan_revisi', 'geom', 'coordinates'], 'string'],
            [['tanggal_survey', 'permit_plan_start', 'permit_plan_end', 'permit_actual_start', 'permit_actual_end', 'create_date', 'special_date', 'approve_date', 'input_area_date'], 'safe'],
            [['coordinat_x', 'coordinat_y', 'rata_rata_okupansi'], 'number'],
            [['location', 'nama_area', 'owner_type', 'kelurahan', 'kecamatan', 'regional', 'pic', 'special_req', 'special_req_sales', 'download_file', 'create_by', 'special_by', 'approve_by', 'input_area_by', 'recommendation', 'team_leader'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_map' => 'Id Map',
            'location' => 'Location',
            'nama_area' => 'Nama Area',
            'hari_survey' => 'Hari Survey',
            'tanggal_survey' => 'Tanggal Survey',
            'owner_type' => 'Owner Type',
            'kelurahan' => 'Kelurahan',
            'kecamatan' => 'Kecamatan',
            'id_iom_city' => 'Id Iom City',
            'regional' => 'Regional',
            'coordinat_x' => 'Coordinat X',
            'coordinat_y' => 'Coordinat Y',
            'home_pass' => 'Home Pass',
            'prioritas' => 'Prioritas',
            'jenis_properti_area' => 'Jenis Properti Area',
            'klasifikasi_jenis_rumah' => 'Klasifikasi Jenis Rumah',
            'rata_rata_okupansi' => 'Rata Rata Okupansi',
            'mayoritas_penghuni_memiliki' => 'Mayoritas Penghuni Memiliki',
            'metode_pembangunan' => 'Metode Pembangunan',
            'akses_penjualan' => 'Akses Penjualan',
            'kompetitor' => 'Kompetitor',
            'pengguna_dth' => 'Pengguna Dth',
            'pic' => 'Pic',
            'note' => 'Note',
            'permit_plan_start' => 'Permit Plan Start',
            'permit_plan_end' => 'Permit Plan End',
            'permit_actual_start' => 'Permit Actual Start',
            'permit_actual_end' => 'Permit Actual End',
            'executor' => 'Executor',
            'special_req' => 'Special Req',
            'special_req_sales' => 'Special Req Sales',
            'download_file' => 'Download File',
            'create_by' => 'Create By',
            'create_date' => 'Create Date',
            'special_by' => 'Special By',
            'special_date' => 'Special Date',
            'approve_by' => 'Approve By',
            'approve_date' => 'Approve Date',
            'input_area_by' => 'Input Area By',
            'input_area_date' => 'Input Area Date',
            'home_pass_potential' => 'Home Pass Potential',
            'recommendation' => 'Recommendation',
            'team_leader' => 'Team Leader',
            'id_survey_batch' => 'Id Survey Batch',
            'id_area' => 'Id Area',
            'status_survey' => 'Status Survey',
            'catatan_revisi' => 'Catatan Revisi',
            'gid' => 'Gid',
            'geom' => 'Geom',
            'coordinates' => 'Coordinates',
        ];
    }
}
