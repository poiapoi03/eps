<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ClientList;

/**
 * ClientListSearch represents the model behind the search form about `\app\models\ClientList`.
 */
class ClientListSearch extends ClientList
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'address', 'created_by', 'updated_by'], 'integer'],
            [['client_name', 'company_name', 'contact_no', 'client_ref_id', 'created_date', 'updated_date','is_active','email'], 'safe'],
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
        $query = ClientList::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'address' => $this->address,
            'created_by' => $this->created_by,
            'created_date' => $this->created_date,
            'updated_by' => $this->updated_by,
            'updated_date' => $this->updated_date,
            'is_active' => $this->is_active,
        ]);

        $query->andFilterWhere(['like', 'client_name', $this->client_name])
            ->andFilterWhere(['like', 'company_name', $this->company_name])
            ->andFilterWhere(['like', 'contact_no', $this->contact_no])
            ->andFilterWhere(['like', 'client_ref_id', $this->client_ref_id])
            ->andFilterWhere(['like', 'email', $this->email]);

        return $dataProvider;
    }
}
