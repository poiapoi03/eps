<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\BillingList;

/**
 * BillingListSearch represents the model behind the search form about `\app\models\BillingList`.
 */
class BillingListSearch extends BillingList
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'project_list_id', 'billing_no', 'bill_status_id', 'payment_mode_id', 'created_by', 'updated_by'], 'integer'],
            [['guid', 'billing_date', 'payment_date', 'payment_reference', 'prepared_by', 'noted_by', 'checked_by', 'created_date', 'updated_date', 'is_active'], 'safe'],
            [['progress_percent'], 'number'],
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
    public function search($params, $pid)
    {
        $query = BillingList::find();

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
            'project_list_id' => $pid,
            'progress_percent' => $this->progress_percent,
            'billing_no' => $this->billing_no,
            'billing_date' => $this->billing_date,
            'bill_status_id' => $this->bill_status_id,
            'payment_mode_id' => $this->payment_mode_id,
            'payment_date' => $this->payment_date,
            'created_by' => $this->created_by,
            'created_date' => $this->created_date,
            'updated_by' => $this->updated_by,
            'updated_date' => $this->updated_date,
        ]);

        $query->andFilterWhere(['like', 'guid', $this->guid])
            ->andFilterWhere(['like', 'payment_reference', $this->payment_reference])
            ->andFilterWhere(['like', 'prepared_by', $this->prepared_by])
            ->andFilterWhere(['like', 'noted_by', $this->noted_by])
            ->andFilterWhere(['like', 'checked_by', $this->checked_by])
            ->andFilterWhere(['like', 'is_active', $this->is_active]);


        return $dataProvider;
    }

    public function searchByClient($params, $pid)
    {
        $query = BillingList::find();

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
            'project_list_id' => $pid,
            'progress_percent' => $this->progress_percent,
            'billing_no' => $this->billing_no,
            'billing_date' => $this->billing_date,
            'bill_status_id' => [2,3],
            'payment_mode_id' => $this->payment_mode_id,
            'payment_date' => $this->payment_date,
            'created_by' => $this->created_by,
            'created_date' => $this->created_date,
            'updated_by' => $this->updated_by,
            'updated_date' => $this->updated_date,
        ]);

        $query->andFilterWhere(['like', 'guid', $this->guid])
            ->andFilterWhere(['like', 'payment_reference', $this->payment_reference])
            ->andFilterWhere(['like', 'prepared_by', $this->prepared_by])
            ->andFilterWhere(['like', 'noted_by', $this->noted_by])
            ->andFilterWhere(['like', 'checked_by', $this->checked_by])
            ->andFilterWhere(['like', 'is_active', $this->is_active]);


        return $dataProvider;
    }
}
