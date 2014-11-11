<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Option */

$this->title = Yii::t('admin', 'Create {modelClass}', [
    'modelClass' => Yii::t('admin', 'Option-a'),
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('admin', 'Options'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="option-create">
    <h1><?= Html::encode($this->title) ?></h1>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>