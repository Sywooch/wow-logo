<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Portfolio */

$this->title = Yii::t('admin', 'Update {modelClass}: ', [
    'modelClass' => Yii::t('admin', 'Portfolio'),
]) . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('admin', 'Portfolios'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['update', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('admin', 'Update');
?>
<div class="portfolio-update">
    <h1><?= Html::encode($this->title) ?></h1>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>