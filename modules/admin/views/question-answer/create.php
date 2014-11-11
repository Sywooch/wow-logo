<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\QuestionAnswer */

$this->title = Yii::t('admin', 'Create {modelClass}', [
    'modelClass' => Yii::t('admin', 'Question Answer'),
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('admin', 'Question Answers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="question-answer-create">
    <h1><?= Html::encode($this->title) ?></h1>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>