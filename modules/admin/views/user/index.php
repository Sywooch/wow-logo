<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $statusArray array */
/* @var $roleArray array */

$this->title = Yii::t('admin', 'Users');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a(Yii::t('admin', 'Create {modelClass}', [
    'modelClass' => Yii::t('admin', 'User-a'),
]), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'username',
            'email:email',
            [
                'attribute' => 'status',
                'format' => 'html',
                'value' => function ($model) {
                        if ($model->status === $model::STATUS_ACTIVE) {
                            $class = 'label-success';
                        } elseif ($model->status === $model::STATUS_INACTIVE) {
                            $class = 'label-warning';
                        } else {
                            $class = 'label-danger';
                        }
                        return '<span class="label ' . $class . '">' . $model->getStatus() . '</span>';
                    },
                'filter' => Html::activeDropDownList(
                        $searchModel,
                        'status',
                        $statusArray,
                        ['class' => 'form-control', 'prompt' => Yii::t('admin', 'Select Status')]
                    )
            ],
            [
                'attribute' => 'role',
                'format' => 'html',
                'value' => function ($model) {
                        if ($model->role === $model::ROLE_USER) {
                            $class = 'label-success';
                        } elseif ($model->role === $model::ROLE_ADMIN) {
                            $class = 'label-warning';
                        } else {
                            $class = 'label-danger';
                        }
                        return '<span class="label ' . $class . '">' . $model->getRole() . '</span>';
                    },
                'filter' => Html::activeDropDownList(
                        $searchModel,
                        'role',
                        $roleArray,
                        ['class' => 'form-control', 'prompt' => Yii::t('admin', 'Select Role')]
                    )
            ],
            'created_at',
            'updated_at',
            ['class' => 'yii\grid\ActionColumn',
                'template' => '{update}',
            ],
        ],
    ]); ?>
</div>