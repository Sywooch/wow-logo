<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Coupon */

$this->title = Yii::t('admin', 'Create {modelClass}', [
    'modelClass' => Yii::t('admin', 'Coupon'),
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('admin', 'Coupons'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="coupon-create">
    <h1><?= Html::encode($this->title) ?></h1>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>