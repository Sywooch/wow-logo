<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\FileInput;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Portfolio */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="portfolio-form">
    <?php $form = ActiveForm::begin(['options' => ['enctype'=>'multipart/form-data']]);

        $images = $model->getImageUrl('images');
        $previews = [];
        foreach ($images as $image) {
            $previews[] = Html::img($image, ['class'=>'file-preview-image']);
        }
    ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => 100]) ?>
    <?= $form->field($model, 'thumbnail')->widget(FileInput::classname(), [
        'options'=> ['accept' => 'image/*'],
        'pluginOptions' => [
            'showUpload' => false,
            'showRemove' => false,
            'showCaption' => false,
            'allowedFileExtensions' => ['jpg','gif','png'],
            'initialPreview'=>[
                Html::img($model->getImageUrl('thumbnail'), ['class'=>'file-preview-image']),
            ],
            'msgInvalidFileType' => Yii::t('app', 'Invalid type for file "{name}". Only "{types}" files are supported.'),
            'msgInvalidFileExtension' => Yii::t('app', 'Invalid extension for file "{name}". Only "{extensions}" files are supported.'),
            'msgLoading' => Yii::t('app', 'Loading file {index} of {files} &hellip;'),
            'msgProgress' => Yii::t('app', 'Loading file {index} of {files} - {name} - {percent}% completed.'),
        ]
    ]); ?>
    <?= $form->field($model, 'images[]')->widget(FileInput::classname(), [
        'options'=> [
            'accept' => 'image/*',
            'multiple' => true,
        ],
        'pluginOptions' => [
            'showUpload' => false,
            'showRemove' => false,
            'showCaption' => false,
            'allowedFileExtensions' => ['jpg','gif','png'],
            'initialPreview' => $previews,
            'msgInvalidFileType' => Yii::t('app', 'Invalid type for file "{name}". Only "{types}" files are supported.'),
            'msgInvalidFileExtension' => Yii::t('app', 'Invalid extension for file "{name}". Only "{extensions}" files are supported.'),
            'msgLoading' => Yii::t('app', 'Loading file {index} of {files} &hellip;'),
            'msgProgress' => Yii::t('app', 'Loading file {index} of {files} - {name} - {percent}% completed.'),
        ]
    ]); ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('admin', 'Create') : Yii::t('admin', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
