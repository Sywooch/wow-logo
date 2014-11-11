<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Coupon */

$this->title = Yii::t('admin', 'Update {modelClass}: ', [
    'modelClass' => Yii::t('admin', 'Coupon'),
]) . ' ' . $model->code;
$this->params['breadcrumbs'][] = ['label' => Yii::t('admin', 'Coupons'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->code, 'url' => ['update', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('admin', 'Update');
?>
<div class="coupon-update">
    <h1><?= Html::encode($this->title) ?></h1>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>