<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\ClientReview */

$this->title = Yii::t('admin', 'Create {modelClass}', [
    'modelClass' => Yii::t('admin', 'Client Review'),
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('admin', 'Client Reviews'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="client-review-create">
    <h1><?= Html::encode($this->title) ?></h1>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
