<?php
    namespace common\models;

    use Yii;
    use yii\base\Model;

    class TanggalDatangForm extends Model
    {
        public $tanggalDatang;

        public function rules()
        {
            return [
                [['tanggalDatang'], 'required'],
            ];
        }
    }
