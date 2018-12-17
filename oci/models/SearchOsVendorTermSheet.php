<?php
namespace os\models;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\OsVendorTermSheet;
/**
 * SearchOsVendorTermSheet represents the model behind the search form about `app\models\OsVendorTermSheet`.
 */
class SearchOsVendorTermSheet extends OsVendorTermSheet
{
    /**
     * @inheritdoc
     */
	public $vendor_name;
    public function rules()
    {
        return [
            [[ 'created_by', 'updated_by', 'status_listing'], 'integer'],
            [['pic_mkm', 'pic_vendor', 'term_sheet', 'pks', 'file_attachment', 'created_date', 'updated_date', 'revision_remark','vendor_name'], 'safe'],
        ];
    }
    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }
    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
	 public function search($params)
     {
         $query = OsVendorTermSheet::find();

         $dataProvider = $this->_search($params, $query);

         return $dataProvider;
     }

    public function _search($params, $query)
    {
        // add conditions that should always apply here
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			// 'sort'=> ['defaultOrder' => ['os_vendor_term_sheet.updated_date'=>SORT_DESC]]
        ]);

		$dataProvider->sort->attributes['vendor_name'] = [
			'asc' => ['os_vendor_regist_vendor.company_name' => SORT_ASC],
			'desc' => ['os_vendor_regist_vendor.company_name' => SORT_DESC],
		];


        $this->load($params);
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

		if ($this->status_listing == 999) {
			$query->andFilterWhere(['=','os_vendor_regist_vendor.status_listing', 5])
			->andWhere(['os_vendor_term_sheet.status_listing' => null]);
		}else {
			$query->andFilterWhere(['=','os_vendor_term_sheet.status_listing', $this->status_listing]);
		}
		
        // grid filtering conditions
		$query->andFilterWhere([
       		'id_os_vendor_regist_vendor' => $this->id_os_vendor_regist_vendor,
            'created_by' => $this->created_by,
            'date(created_date)' => $this->created_date,
			'date(updated_date)' => $this->updated_date,
            'updated_by' => $this->updated_by,
            // 'os_vendor_term_sheet.status_listing' => $this->status_listing,
        ]);
        $query->andFilterWhere(['ilike', 'labor.name', $this->pic_mkm])
            ->andFilterWhere(['ilike', 'pic_vendor', $this->pic_vendor])
            ->andFilterWhere(['ilike', 'term_sheet', $this->term_sheet])
            ->andFilterWhere(['ilike', 'pks', $this->pks])
            ->andFilterWhere(['ilike', 'file_attachment', $this->file_attachment])
			 ->andFilterWhere(['ilike', 'os_vendor_regist_vendor.company_name', $this->vendor_name])
            ->andFilterWhere(['ilike', 'revision_remark', $this->revision_remark]);
        return $dataProvider;
    }
	public function searchByAction($params, $action)
    {
		 $query = OsVendorTermSheet::find();
		 $query->joinWith('picMkm');
		 $query->joinWith('idVendorRegistration',true,'FULL JOIN')
	           ->andFilterWhere(['=','os_vendor_regist_vendor.status_listing', 5]);
		 $query->select([   'os_vendor_regist_vendor.id as id_os_vendor_regist',
		                    'os_vendor_term_sheet.id_os_vendor_regist_vendor',
							'os_vendor_regist_vendor.company_name as vendor_name',
							'os_vendor_term_sheet.term_sheet',
							'os_vendor_term_sheet.pks',
							'os_vendor_term_sheet.pic_vendor',
							'os_vendor_term_sheet.pic_mkm',
							'os_vendor_term_sheet.status_listing',
							]);
		if($action == 'input') {
		     $query ->andWhere(['os_vendor_term_sheet.status_listing' => null])
                ->orFilterWhere(['not in','os_vendor_term_sheet.status_listing' , [4, 5]])
			     // ->orderBy(['os_vendor_term_sheet.id_os_vendor_regist_vendor' => SORT_DESC])
				 ;
		} else if ($action == 'verify') {
			$query->andFilterWhere(['or',['=','os_vendor_term_sheet.status_listing', 1],['=','os_vendor_term_sheet.status_listing', 4], ['=','os_vendor_term_sheet.status_listing', 2]])
				 // ->orderBy(['os_vendor_term_sheet.id_os_vendor_regist_vendor' => SORT_DESC])
				 ;
		}
		else if ($action == 'approve') {
			$query->andFilterWhere(['or',['=','os_vendor_term_sheet.status_listing', 4],['=','os_vendor_term_sheet.status_listing', 5]])
			// ->orderBy(['os_vendor_term_sheet.id_os_vendor_regist_vendor' => SORT_DESC])
			;
		} else if ($action == 'overview') {
			// $query ->orderBy(['os_vendor_term_sheet.id_os_vendor_regist_vendor' => SORT_DESC]);
        }

 // grid filtering conditions
		 $dataProvider = $this->_search($params, $query);

		 return $dataProvider;
	}
}
