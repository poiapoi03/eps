<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\User;

/**
 * UserSearch represents the model behind the search form about `\app\models\User`.
 */
class UserSearch extends User
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'flags', 'confirmed_at', 'blocked_at', 'updated_at', 'created_at', 'last_login_at', 'password_changed_at', 'gdpr_consent_date', 'status', 'user_type', 'client_list_id'], 'integer'],
            [['username', 'email', 'password_hash', 'auth_key', 'unconfirmed_email', 'registration_ip', 'last_login_ip', 'auth_tf_key', 'auth_tf_enabled', 'gdpr_consent', 'gdpr_deleted'], 'safe'],
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
    // public function search1($params, $client_id)
    // {
    //     $query = User::find();

    //     $dataProvider = new ActiveDataProvider([
    //         'query' => $query,
    //     ]);

    //     $this->load($params);

    //     if (!$this->validate()) {
    //         // uncomment the following line if you do not want to return any records when validation fails
    //         // $query->where('0=1');
    //         return $dataProvider;
    //     }

    //     $query->andFilterWhere([
    //         'id' => $this->id,
    //         'flags' => $this->flags,
    //         'confirmed_at' => $this->confirmed_at,
    //         'blocked_at' => $this->blocked_at,
    //         'updated_at' => $this->updated_at,
    //         'created_at' => $this->created_at,
    //         'last_login_at' => $this->last_login_at,
    //         'password_changed_at' => $this->password_changed_at,
    //         'gdpr_consent_date' => $this->gdpr_consent_date,
    //         'status' => $this->status,
    //         'user_type' => $this->user_type,
    //         'client_list_id' => $client_id,
    //     ]);

    //     $query->andFilterWhere(['like', 'username', $this->username])
    //         ->andFilterWhere(['like', 'email', $this->email])
    //         ->andFilterWhere(['like', 'password_hash', $this->password_hash])
    //         ->andFilterWhere(['like', 'auth_key', $this->auth_key])
    //         ->andFilterWhere(['like', 'unconfirmed_email', $this->unconfirmed_email])
    //         ->andFilterWhere(['like', 'registration_ip', $this->registration_ip])
    //         ->andFilterWhere(['like', 'last_login_ip', $this->last_login_ip])
    //         ->andFilterWhere(['like', 'auth_tf_key', $this->auth_tf_key])
    //         ->andFilterWhere(['like', 'auth_tf_enabled', $this->auth_tf_enabled])
    //         ->andFilterWhere(['like', 'gdpr_consent', $this->gdpr_consent])
    //         ->andFilterWhere(['like', 'gdpr_deleted', $this->gdpr_deleted]);

    //     return $dataProvider;
    // }
}
