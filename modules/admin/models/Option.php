<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "option".
 *
 * @property string $id
 * @property string $name
 * @property double $price
 * @property integer $is_published
 *
 * @property Order[] $orders
 */
class Option extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'option';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'price'], 'required'],
            [['price'], 'number'],
            [['is_published'], 'integer'],
            [['name'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('admin', 'ID'),
            'name' => Yii::t('admin', 'Title'),
            'price' => Yii::t('admin', 'Price'),
            'is_published' => Yii::t('admin', 'Is Published'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Order::className(), ['id' => 'order_id'])->viaTable('order_has_option', ['option_id' => 'id']);
    }
}