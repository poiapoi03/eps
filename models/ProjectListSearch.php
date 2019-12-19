<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ProjectList;

/**
 * ProjectListSearch represents the model behind the search form about `\app\models\ProjectList`.
 */
class ProjectListSearch extends ProjectList
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'client_list_id', 'created_by', 'updated_by'], 'integer'],
            [['guid', 'project_title', 'deposit_percent', 'retention_percent', 'project_ref_id', 'start_date', 'end_date', 'created_date', 'updated_date', 'is_active'], 'safe'],
            [['contract_price', 'deposit_amount', 'retention_amount'], 'number'],
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
        $query = ProjectList::find();

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
            'client_list_id' => $this->client_list_id,
            'contract_price' => $this->contract_price,
            'deposit_amount' => $this->deposit_amount,
            'retention_amount' => $this->retention_amount,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'created_by' => $this->created_by,
            'created_date' => $this->created_date,
            'updated_by' => $this->updated_by,
            'updated_date' => $this->updated_date,
        ]);

        $query->andFilterWhere(['like', 'guid', $this->guid])
            ->andFilterWhere(['like', 'project_title', $this->project_title])
            ->andFilterWhere(['like', 'deposit_percent', $this->deposit_percent])
            ->andFilterWhere(['like', 'retention_percent', $this->retention_percent])
            ->andFilterWhere(['like', 'project_ref_id', $this->project_ref_id])
            ->andFilterWhere(['like', 'is_active', $this->is_active]);

        return $dataProvider;
    }
}
