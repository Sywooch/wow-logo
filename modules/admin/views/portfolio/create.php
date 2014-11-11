<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Portfolio */

$this->title = Yii::t('admin', 'Create {modelClass}', [
    'modelClass' => Yii::t('admin', 'Portfolio'),
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('admin', 'Portfolios'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="portfolio-create">
    <h1><?= Html::encode($this->title) ?></h1>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
