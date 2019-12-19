<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\BillingDetails;

/**
 * BillingDetailsSearch represents the model behind the search form about `\app\models\BillingDetails`.
 */
class BillingDetailsSearch extends BillingDetails
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'billing_list_id', 'collection_type_id'], 'integer'],
            [['guid', 'remarks'], 'safe'],
            [['amount'], 'number'],
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
    public function search($params, $blid)
    {
        $query = BillingDetails::find();

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
            'billing_list_id' => $blid,
            'collection_type_id' => $this->collection_type_id,
            'amount' => $this->amount,
        ]);

        $query->andFilterWhere(['like', 'guid', $this->guid])
            ->andFilterWhere(['like', 'remarks', $this->remarks]);

        return $dataProvider;
    }
}
