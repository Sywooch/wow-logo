<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Option */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="option-form">
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'is_published')->checkbox() ?>
    <?= $form->field($model, 'name')->textInput(['maxlength' => 100]) ?>
    <?= $form->field($model, 'price')->textInput(['maxlength' => 12]) ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('admin', 'Create') : Yii::t('admin', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>