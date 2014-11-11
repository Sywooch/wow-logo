<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\OrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $statusArray array */
/* @var $tariffArray array */

$this->title = Yii::t('admin', 'Orders');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a(Yii::t('admin', 'Create {modelClass}', [
    'modelClass' => Yii::t('admin', 'Order'),
]), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'client_email:email',
            'company_name',
//            'site_link',
            [
                'attribute' => 'tariff',
                'format' => 'html',
                'value' => function ($model) {
                    if ($model->tariff === $model::TARIFF_START) {
                        $class = 'label-success';
                    } elseif ($model->tariff === $model::TARIFF_BUSINESS) {
                        $class = 'label-warning';
                    } else {
                        $class = 'label-danger';
                    }
                    return '<span class="label ' . $class . '">' . $model->getTariff() . '</span>';
                },
                'filter' => Html::activeDropDownList(
                    $searchModel,
                    'tariff',
                    $tariffArray,
                    ['class' => 'form-control', 'prompt' => Yii::t('admin', 'Select Tariff')]
                )
            ],
            'logo_variants',
            // 'price_no_disc',
            [
                'attribute' => 'status',
                'format' => 'html',
                'value' => function ($model) {
                        if ($model->status === $model::STATUS_NEW) {
                            $class = 'label-warning';
                            $style = '';
                        } elseif ($model->status === $model::STATUS_NOT_PAYED) {
                            $class = 'label-danger';
                            $style = '';
                        } elseif ($model->status === $model::STATUS_IN_WORK) {
                            $class = '';
                            $style = 'background-color: #88FC7E;';
                        } elseif ($model->status === $model::STATUS_EDIT_STAGE) {
                            $class = 'label-info';
                            $style = '';
                        } elseif ($model->status === $model::STATUS_EDITS_NEEDED) {
                            $class = '';
                            $style = 'background-color: #9DECE0;';
                        } elseif ($model->status === $model::STATUS_BLUEPRINTS_NEEDED) {
                            $class = '';
                            $style = 'background-color: #8B3FBD;';
                        } elseif ($model->status === $model::STATUS_CLIENT_CHECK) {
                            $class = 'label-success';
                            $style = '';
                        } else {
                            $class = 'label-default';
                            $style = '';
                        }
                        return '<span class="label ' . $class . '" style="' . $style . '">' . $model->getStatus() . '</span>';
                    },
                'filter' => Html::activeDropDownList(
                        $searchModel,
                        'status',
                        $statusArray,
                        ['class' => 'form-control', 'prompt' => Yii::t('admin', 'Select Status')]
                    )
            ],
            'price',
            'created_at',
            ['class' => 'yii\grid\ActionColumn',
                'template' => '{update}',
            ],
        ],
    ]); ?>
</div>