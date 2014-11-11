<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "order_has_portfolio".
 *
 * @property string $order_id
 * @property string $portfolio_id
 *
 * @property Order $order
 * @property Portfolio $portfolio
 */
class OrderHasPortfolio extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order_has_portfolio';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_id', 'portfolio_id'], 'required'],
            [['order_id', 'portfolio_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'order_id' => Yii::t('admin', 'Order ID'),
            'portfolio_id' => Yii::t('admin', 'Portfolio ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrder()
    {
        return $this->hasOne(Order::className(), ['id' => 'order_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPortfolio()
    {
        return $this->hasOne(Portfolio::className(), ['id' => 'portfolio_id']);
    }
}
