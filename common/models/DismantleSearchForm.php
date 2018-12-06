<?php

namespace common\models;

use common\constants\DismantleConstants;
use divisitiga\models\Dismantle;
use divisitiga\models\DismantleTagSn;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use Faker\Factory;

class DismantleSearchForm extends Model
{
    public $id;
    public $status;
    public $dismantle_number;
    public $wo_number;
    public $customer_name;
    public $name;
    public $customer_id;
    public $customer_address;
    public $address;
    public $created_by;
    public $updated_by;
    public $customer_type;
    public $customer_block;
    public $customer_home_phone;
    public $customer_phone;
    public $customer_email;
    public $dismantle_date;
    public $visit_date;
    public $revision_mark;
    public $file;
    public $officer_name;
    public $reason;

    public $item_name;
    public $im_code;
    public $brand;
    public $qty;
    public $dismantle_recond_qty;
    public $dismantle_reject_qty;
    public $sn_status;
    public $delta_qty;
    public $dismantle_status;
    public $isNewRecord = 1;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['wo_number', 'dismantle_date', 'visit_date', 'officer_name'], 'required'],
            [['id', 'created_by', 'updated_by', 'status'], 'integer'],
            [['dismantle_number', 'customer_name', 'customer_id', 'customer_home_phone',
                'dismantle_date', 'visit_date', 'officer_name', 'file', 'revision_mark', 'reason',
                'customer_address', 'customer_type', 'customer_block', 'customer_email', 'customer_phone',
                'wo_number', 'dismantle_date', 'visit_date', 'officer_name', 'name', 'address'
                ], 'safe'],
            [['file'], 'file', 'extensions' => 'pdf', 'maxSize'=>1024*1024*5],
        ];
    }

    public function search(array $params = [], $id_modul, $action)
    {
        $query = Dismantle::find()->innerJoinWith('customer', true);

        if ($action == 'tag-sn') {
            $query->andWhere(['!=','status', DismantleConstants::STATUS_NEED_REVISED]);
        }
        $this->load($params);

        foreach ($params as $row) {
            foreach ($row as $key => $item) {
                if (!empty($item)) {
                    if ($key == 'wo_number') {
                        $query->andWhere(['LIKE','dismantle.'.$key, $item]);
                    } else {
                        $query->andWhere(['LIKE',$key, $item]);
                    }
                }
            }
        }
        $query->orderBy(['id' => \SORT_DESC]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 100,
            ],
            'sort' => [
                'attributes' => ['id', 'name'],
            ],
        ]);

        return $dataProvider;
    }

    public function viewDetail($id)
    {
        $data = DismantleTagSn::find()->andWhere(['dismantle_id' => $id])->all();
        if (empty($data)) {
            $data = DismantleTagSn::getTagSnMock();
        }

        $dataProvider = new ArrayDataProvider([
            'allModels' => $data,
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => [
                'attributes' => ['id', 'name'],
            ],
        ]);

        return $dataProvider;
    }

    public function searchTagSN(array $params = [], int $id_modul, string $action)
    {
        $data = DismantleTagSn::getTagSnMock();
        $dataProvider = new ArrayDataProvider([
            'allModels' => $data,
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => [
                'attributes' => ['id', 'name'],
            ],
        ]);

        return $dataProvider;
    }

    public function _search($params, $query)
    {
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['created_date' => SORT_DESC]]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        return $dataProvider;
    }

    /**
     *
     */
    public function loadAttribute()
    {
        $faker = Factory::create();
        $this->item_name = $faker->name;
        $this->im_code = $faker->numberBetween(0, 10) . '/DISMTL/VI/18';
        $this->brand ='MNC';
        $this->qty = $faker->numberBetween(1, 10);
        $this->dismantle_recond_qty = $faker->numberBetween(1, 10);
        $this->dismantle_reject_qty = $faker->numberBetween(1, 10);
        $this->sn_status = $faker->numberBetween(1, 10);
        $this->dismantle_status = $faker->numberBetween(1, 10);
    }
}
