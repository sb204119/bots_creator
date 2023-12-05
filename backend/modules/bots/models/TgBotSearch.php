<?php

namespace backend\modules\bots\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\bots\models\TgBot;

/**
 * TgBotSearch represents the model behind the search form of `backend\modules\bots\models\TgBot`.
 */
class TgBotSearch extends TgBot
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['token', 'service_name', 'bot_name', 'welcome_message', 'menu', 'description', 'webhook_url'], 'safe'],
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
        $query = TgBot::find();

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
        ]);

        $query->andFilterWhere(['like', 'token', $this->token])
            ->andFilterWhere(['like', 'service_name', $this->service_name])
            ->andFilterWhere(['like', 'bot_name', $this->bot_name])
            ->andFilterWhere(['like', 'welcome_message', $this->welcome_message])
            ->andFilterWhere(['like', 'menu', $this->menu])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'webhook_url', $this->webhook_url]);

        return $dataProvider;
    }
}
