<?php

namespace app\modules\admin\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\admin\models\Order;

/**
 * OrderSearch represents the model behind the search form about `app\modules\admin\models\Order`.
 */
class OrderSearch extends Order
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'tariff_id', 'logo_variants', 'hilarity', 'modernity', 'minimalism', 'coupon_id'], 'integer'],
            [['client_email', 'skype', 'telephone', 'company_name', 'site_link', 'description', 'money_earning', 'who_clients', 'company_strength', 'who_competitors', 'images_urls', 'files_urls', 'color_scheme'], 'safe'],
            [['price_no_disc', 'price'], 'number'],
            ['status', 'in', 'range' => array_keys(self::getStatusArray())],
            ['composition', 'in', 'range' => array_keys(self::getCompositionArray())],
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
        $query = Order::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
            'composition' => $this->composition,
            'tariff_id' => $this->tariff_id,
            'logo_variants' => $this->logo_variants,
//            'hilarity' => $this->hilarity,
//            'modernity' => $this->modernity,
//            'minimalism' => $this->minimalism,
            'price_no_disc' => $this->price_no_disc,
            'price' => $this->price,
            'coupon_id' => $this->coupon_id,
        ]);

        $query->andFilterWhere(['like', 'client_email', $this->client_email])
            ->andFilterWhere(['like', 'skype', $this->skype])
            ->andFilterWhere(['like', 'telephone', $this->telephone])
            ->andFilterWhere(['like', 'company_name', $this->company_name])
            ->andFilterWhere(['like', 'site_link', $this->site_link])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'money_earning', $this->money_earning])
            ->andFilterWhere(['like', 'who_clients', $this->who_clients])
            ->andFilterWhere(['like', 'company_strength', $this->company_strength])
            ->andFilterWhere(['like', 'who_competitors', $this->who_competitors])
            ->andFilterWhere(['like', 'images_urls', $this->images_urls])
            ->andFilterWhere(['like', 'files_urls', $this->files_urls])
            ->andFilterWhere(['like', 'color_scheme', $this->color_scheme]);

        return $dataProvider;
    }
}