<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\CouponSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('admin', 'Coupons');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="coupon-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a(Yii::t('admin', 'Create {modelClass}', [
    'modelClass' => Yii::t('admin', 'Coupon'),
]), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'code',
            'price_drop',
            [
                'attribute' => 'is_used',
                'format' => 'html',
                'value' => function ($model) {
                    if ($model->is_used == true) {
                        $class = 'label-danger';
                        $value = Yii::t('admin', 'Yes');
                    } else {
                        $class = 'label-success';
                        $value = Yii::t('admin', 'No');
                    }
                    return '<span class="label ' . $class . '">' . $value . '</span>';
                },
                'filter' => Html::activeDropDownList(
                    $searchModel,
                    'is_used',
                    [1 => Yii::t('admin', 'Yes'), 0 => Yii::t('admin', 'No')],
                    ['class' => 'form-control', 'prompt' => Yii::t('admin', 'Select Filter')]
                )
            ],
            'created_at',
            ['class' => 'yii\grid\ActionColumn',
                'template' => '{update}',
            ],
        ],
    ]); ?>
</div>