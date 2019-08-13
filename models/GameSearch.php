<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Game;

/**
 * GameSearch represents the model behind the search form of `app\models\Game`.
 */
class GameSearch extends Game
{
    /**
     * {@inheritdoc}
     */
    public function attributes()
    {
        // add related fields to searchable attributes
        return array_merge(parent::attributes(), ['platform.name']);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'platform_id'], 'integer'],
            [['title', 'platform.name', 'state'], 'safe'],
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
        $query = Game::find();

        // add conditions that should always apply here
        $query->joinWith('platform AS platform')
              ->joinWith('emulatedPlatform AS emulated_platform')
              ->andWhere(['dlc_of_id' => null]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['created_at' => SORT_DESC, 'title' => SORT_ASC]]
        ]);

        $dataProvider->sort->attributes['platform.name'] = [
            'asc' => ['platform.name' => SORT_ASC],
            'desc' => ['platform.name' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'platform_id' => $this->platform_id,
        ]);

        $query->andFilterWhere(['like', 'LOWER(title)', strtolower($this->title)]);

        $query->andFilterWhere(['or',
            ['=', 'platform.name', $this->getAttribute('platform.name')],
            ['=', 'emulated_platform.name', $this->getAttribute('platform.name')]
        ]);
        
        $query->andFilterWhere(['=', 'state', $this->getAttribute('state')]);

        return $dataProvider;
    }
}
