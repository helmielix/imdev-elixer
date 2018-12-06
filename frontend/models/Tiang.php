<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tiang".
 *
 * @property integer $gid
 * @property string $name
 * @property string $tiang_id
 * @property string $area_id
 * @property integer $map_id
 * @property string $color
 * @property string $owner_type
 * @property string $location_c
 * @property string $address
 * @property string $kelurahan
 * @property string $kecamatan
 * @property string $region
 * @property string $kota
 * @property string $longitude
 * @property string $lattitude
 * @property integer $qty_pole
 * @property string $pole_type
 * @property string $pole_statu
 * @property string $pole_owner
 * @property string $cable_stat
 * @property string $cable_type
 * @property integer $cable_leng
 * @property string $odc_status
 * @property integer $odc_qty
 * @property string $fat_status
 * @property integer $fat_qty
 * @property integer $closure_qt
 * @property integer $ikr
 * @property integer $klem_ancho
 * @property integer $dead_end_b
 * @property integer $sling_brac
 * @property integer $suspension
 * @property integer $slack_supp
 * @property integer $steel_band
 * @property integer $bekel_stop
 * @property integer $pole_strap
 * @property string $klem_ring
 * @property string $remark
 * @property string $date_input
 * @property string $kml_style
 * @property string $kml_folder
 * @property string $geom
 */
class Tiang extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tiang';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['map_id', 'qty_pole', 'cable_leng', 'odc_qty', 'fat_qty', 'closure_qt', 'ikr', 'klem_ancho', 'dead_end_b', 'sling_brac', 'suspension', 'slack_supp', 'steel_band', 'bekel_stop', 'pole_strap'], 'integer'],
            [['longitude', 'lattitude'], 'number'],
            [['geom'], 'string'],
            [['name', 'tiang_id'], 'string', 'max' => 21],
            [['area_id', 'date_input'], 'string', 'max' => 10],
            [['color', 'pole_owner', 'odc_status', 'fat_status'], 'string', 'max' => 3],
            [['owner_type'], 'string', 'max' => 5],
            [['location_c', 'address'], 'string', 'max' => 22],
            [['kelurahan'], 'string', 'max' => 13],
            [['kecamatan', 'kml_style'], 'string', 'max' => 14],
            [['region'], 'string', 'max' => 7],
            [['kota'], 'string', 'max' => 15],
            [['pole_type', 'pole_statu', 'cable_stat'], 'string', 'max' => 2],
            [['cable_type'], 'string', 'max' => 4],
            [['klem_ring'], 'string', 'max' => 1],
            [['remark'], 'string', 'max' => 33],
            [['kml_folder'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'gid' => 'Gid',
            'name' => 'Name',
            'tiang_id' => 'Tiang ID',
            'area_id' => 'Area ID',
            'map_id' => 'Map ID',
            'color' => 'Color',
            'owner_type' => 'Owner Type',
            'location_c' => 'Location C',
            'address' => 'Address',
            'kelurahan' => 'Kelurahan',
            'kecamatan' => 'Kecamatan',
            'region' => 'Region',
            'kota' => 'Kota',
            'longitude' => 'Longitude',
            'lattitude' => 'Lattitude',
            'qty_pole' => 'Qty Pole',
            'pole_type' => 'Pole Type',
            'pole_statu' => 'Pole Statu',
            'pole_owner' => 'Pole Owner',
            'cable_stat' => 'Cable Stat',
            'cable_type' => 'Cable Type',
            'cable_leng' => 'Cable Leng',
            'odc_status' => 'Odc Status',
            'odc_qty' => 'Odc Qty',
            'fat_status' => 'Fat Status',
            'fat_qty' => 'Fat Qty',
            'closure_qt' => 'Closure Qt',
            'ikr' => 'Ikr',
            'klem_ancho' => 'Klem Ancho',
            'dead_end_b' => 'Dead End B',
            'sling_brac' => 'Sling Brac',
            'suspension' => 'Suspension',
            'slack_supp' => 'Slack Supp',
            'steel_band' => 'Steel Band',
            'bekel_stop' => 'Bekel Stop',
            'pole_strap' => 'Pole Strap',
            'klem_ring' => 'Klem Ring',
            'remark' => 'Remark',
            'date_input' => 'Date Input',
            'kml_style' => 'Kml Style',
            'kml_folder' => 'Kml Folder',
            'geom' => 'Geom',
        ];
    }
}
