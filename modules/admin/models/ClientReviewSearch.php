<?php

namespace app\modules\admin\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\admin\models\ClientReview;

/**
 * ClientReviewSearch represents the model behind the search form about `app\models\ClientReview`.
 */
class ClientReviewSearch extends ClientReview
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'is_published'], 'integer'],
            [['name', 'position', 'comment', 'site_link', 'logo_url', 'client_image_url'], 'safe'],
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
        $query = ClientReview::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'is_published' => $this->is_published,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'position', $this->position])
            ->andFilterWhere(['like', 'comment', $this->comment])
            ->andFilterWhere(['like', 'site_link', $this->site_link])
            ->andFilterWhere(['like', 'logo_url', $this->logo_url])
            ->andFilterWhere(['like', 'client_image_url', $this->client_image_url]);

        return $dataProvider;
    }
}
