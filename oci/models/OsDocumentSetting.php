<?php

namespace os\models;

use Yii;

/**
 * This is the model class for table "finance_invoice_document".
 *
 * @property integer $id
 * @property integer $id_finance_invoice
 * @property string $document_name
 * @property string $document
 *
 * @property FinanceInvoice $idFinanceInvoice
 */
class OsDocumentSetting extends \yii\db\ActiveRecord
{
    
	public $file;
    public static function tableName()
    {
        return 'finance_invoice_document';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_finance_invoice', 'document_name'], 'required'],
            [['id_finance_invoice'], 'integer'],
            [['document_name'], 'string', 'max' => 60],
            [['document'], 'string', 'max' => 255],
            [['id_finance_invoice'], 'exist', 'skipOnError' => true, 'targetClass' => FinanceInvoice::className(), 'targetAttribute' => ['id_finance_invoice' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_finance_invoice' => 'Id Finance Invoice',
            'document_name' => 'Document Name',
            'document' => 'Document',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdFinanceInvoice()
    {
        return $this->hasOne(FinanceInvoice::className(), ['id' => 'id_finance_invoice']);
    }
}
