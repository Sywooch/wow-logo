<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\DateTimePicker;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Coupon */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="coupon-form">
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'is_used')->checkbox() ?>
    <?= $form->field($model, 'code')->textInput(['maxlength' => 64]) ?>
    <?= $form->field($model, 'price_drop')->textInput(['maxlength' => 12]) ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('admin', 'Create') : Yii::t('admin', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
