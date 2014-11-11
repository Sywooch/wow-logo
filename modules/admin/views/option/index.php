<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\OptionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('admin', 'Options');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="option-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a(Yii::t('admin', 'Create {modelClass}', [
    'modelClass' => Yii::t('admin', 'Option-a'),
]), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name',
            'price',
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
            ['class' => 'yii\grid\ActionColumn',
                'template' => '{update}',
            ],
        ],
    ]); ?>

</div>
