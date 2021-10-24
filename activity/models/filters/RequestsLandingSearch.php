<?php

namespace app\models\filters;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\records\RequestsLanding;

/**
 * RequestsLandingSearch represents the model behind the search form of `app\models\records\RequestsLanding`.
 */
class RequestsLandingSearch extends RequestsLanding
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['url', 'date_request'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = RequestsLanding::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'date_request' => $this->date_request,
        ]);

        $query->andFilterWhere(['ilike', 'url', $this->url]);

        return $dataProvider;
    }
}
