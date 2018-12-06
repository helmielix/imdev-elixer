<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "am_stock_opname_fa".
 *
 * @property string $stock_opname_number
 * @property integer $status_listing
 * @property integer $created_by
 * @property integer $updated_by
 * @property string $id_warehouse
 * @property string $pic
 * @property string $cut_off_data
 * @property string $file
 * @property string $revision_remark
 * @property string $created_date
 * @property string $updated_date
 * @property integer $id_modul
 * @property string $sto_start_date
 * @property string $sto_end_date
 * @property string $time_cut_off_data
 *
 * @property Modul $idModul
 * @property StatusReference $statusListing
 * @property User $createdBy
 * @property User $updatedBy
 */
class AmStockOpnameFa extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'am_stock_opname_fa';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['stock_opname_number', 'status_listing', 'created_by', 'updated_by', 'id_warehouse', 'cut_off_data', 'id_modul', 'sto_start_date', 'sto_end_date', 'time_cut_off_data'], 'required'],
            [['stock_opname_number', 'id_warehouse', 'pic', 'file', 'revision_remark'], 'string'],
            [['status_listing', 'created_by', 'updated_by', 'id_modul'], 'integer'],
            [['cut_off_data', 'created_date', 'updated_date', 'sto_start_date', 'sto_end_date', 'time_cut_off_data'], 'safe'],
            [['id_modul'], 'exist', 'skipOnError' => true, 'targetClass' => Modul::className(), 'targetAttribute' => ['id_modul' => 'id']],
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
            'stock_opname_number' => 'Stock Opname Number',
            'status_listing' => 'Status Listing',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'id_warehouse' => 'Id Warehouse',
            'pic' => 'Pic',
            'cut_off_data' => 'Cut Off Data',
            'file' => 'File',
            'revision_remark' => 'Revision Remark',
            'created_date' => 'Created Date',
            'updated_date' => 'Updated Date',
            'id_modul' => 'Id Modul',
            'sto_start_date' => 'Sto Start Date',
            'sto_end_date' => 'Sto End Date',
            'time_cut_off_data' => 'Time Cut Off Data',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdModul()
    {
        return $this->hasOne(Modul::className(), ['id' => 'id_modul']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatusListing()
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
}
