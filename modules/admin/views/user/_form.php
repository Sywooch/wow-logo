<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'username')->textInput(['maxlength' => 255]) ?>
    <?= $form->field($model, 'email')->textInput(['maxlength' => 255]) ?>
    <?= $form->field($model, 'password')->passwordInput(['maxlength' => 30]) ?>
    <?= $form->field($model, 'repassword')->passwordInput(['maxlength' => 30]) ?>
    <?= $form->field($model, 'role')->dropDownList(
        $model->getRoleArray(),
        ['prompt' => Yii::t('admin', 'Select Role')])
    ?>
    <?= $form->field($model, 'status')->dropDownList(
        $model->getStatusArray(),
        ['prompt' => Yii::t('admin', 'Select Status')])
    ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('admin', 'Create') : Yii::t('admin', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>