<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\FileInput;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\ClientReview */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="client-review-form">
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    <?= $form->field($model, 'is_published')->checkbox() ?>
    <?= $form->field($model, 'name')->textInput(['maxlength' => 255]) ?>
    <?= $form->field($model, 'position')->textInput(['maxlength' => 255]) ?>
    <?= $form->field($model, 'comment')->textarea(['rows' => 6]) ?>
    <?= $form->field($model, 'site_link')->textInput(['maxlength' => 255]) ?>
    <?= $form->field($model, 'logo')->widget(FileInput::classname(), [
        'options'=> ['accept' => 'image/*'],
        'pluginOptions' => [
            'showUpload' => false,
            'showRemove' => false,
            'showCaption' => false,
            'allowedFileExtensions' => ['jpg','gif','png'],
            'initialPreview'=>[
                Html::img($model->getImageUrl('logo'), ['class'=>'file-preview-image']),
            ],
            'msgInvalidFileType' => Yii::t('app', 'Invalid type for file "{name}". Only "{types}" files are supported.'),
            'msgInvalidFileExtension' => Yii::t('app', 'Invalid extension for file "{name}". Only "{extensions}" files are supported.'),
            'msgLoading' => Yii::t('app', 'Loading file {index} of {files} &hellip;'),
            'msgProgress' => Yii::t('app', 'Loading file {index} of {files} - {name} - {percent}% completed.'),
        ]
    ]); ?>
    <?= $form->field($model, 'clientImage')->widget(FileInput::classname(), [
        'options'=> ['accept' => 'image/*'],
        'pluginOptions' => [
            'showUpload' => false,
            'showRemove' => false,
            'showCaption' => false,
            'allowedFileExtensions' => ['jpg','gif','png'],
            'initialPreview'=>[
                Html::img($model->getImageUrl('clientImage'), ['class'=>'file-preview-image']),
            ],
            'msgInvalidFileType' => Yii::t('app', 'Invalid type for file "{name}". Only "{types}" files are supported.'),
            'msgInvalidFileExtension' => Yii::t('app', 'Invalid extension for file "{name}". Only "{extensions}" files are supported.'),
            'msgLoading' => Yii::t('app', 'Loading file {index} of {files} &hellip;'),
            'msgProgress' => Yii::t('app', 'Loading file {index} of {files} - {name} - {percent}% completed.'),
        ]
    ]); ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('admin', 'Create') : Yii::t('admin', 'Update'), ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>