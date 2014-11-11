<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel app\modules\admin\models\ClientReviewSearch; */

$this->title = Yii::t('admin', 'Client Reviews');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="client-review-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('admin', 'Create {modelClass}', [
    'modelClass' => Yii::t('admin', 'Client Review'),
]), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name',
            'position',
//            'comment:ntext',
            'site_link',
            [
                'attribute' => 'is_published',
                'format' => 'html',
                'value' => function ($model) {
                        if ($model->is_published == true) {
                            $class = 'label-success';
                            $value = Yii::t('admin', 'Yes');
                        } else {
                            $class = 'label-danger';
                            $value = Yii::t('admin', 'No');
                        }
                        return '<span class="label ' . $class . '">' . $value . '</span>';
                    },
                'filter' => Html::activeDropDownList(
                        $searchModel,
                        'is_published',
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
