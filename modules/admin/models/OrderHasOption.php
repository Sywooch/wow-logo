<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "order_has_option".
 *
 * @property string $order_id
 * @property string $option_id
 *
 * @property Order $order
 * @property Option $option
 */
class OrderHasOption extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order_has_option';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_id', 'option_id'], 'required'],
            [['order_id', 'option_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'order_id' => Yii::t('admin', 'Order ID'),
            'option_id' => Yii::t('admin', 'Option ID'),
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
    public function getOption()
    {
        return $this->hasOne(Option::className(), ['id' => 'option_id']);
    }
}
