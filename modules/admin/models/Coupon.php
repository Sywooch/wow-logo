<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "coupon".
 *
 * @property integer $id
 * @property string $code
 * @property double $price_drop
 * @property string $created_at
 * @property integer $is_used
 *
 * @property Order $order
 */
class Coupon extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'coupon';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code', 'price_drop', 'created_at'], 'required'],
            [['price_drop'], 'number'],
            [['created_at'], 'safe'],
            [['is_used'], 'integer'],
            [['code'], 'string', 'max' => 64],
            [['code'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('admin', 'ID'),
            'code' => Yii::t('admin', 'Code'),
            'price_drop' => Yii::t('admin', 'Price Drop'),
            'created_at' => Yii::t('admin', 'Created At'),
            'is_used' => Yii::t('admin', 'Is Used'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrder()
    {
        return $this->hasOne(Order::className(), ['coupon_id' => 'id']);
    }

    public static function checkCouponByCode($code)
    {
        /** @var Coupon $coupon */
        $coupon = Coupon::find()->where([
            'code' => $code,
            'is_used' => false
        ])->one();
        if ($coupon) {
            if ($coupon->order) {
                $coupon->is_used = true;
                $coupon->save(false);
            } else {
                return $coupon;
            }
        }
        return false;
    }
}
