<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\modules\admin\models\Coupon;
use app\modules\admin\models\User;
use app\modules\admin\models\Portfolio;
use app\modules\admin\models\Option;
use kartik\widgets\ColorInput;
use kartik\slider\Slider;
use kartik\widgets\Select2;
use kartik\widgets\FileInput;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Order */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="order-form">
    <?php $form = ActiveForm::begin(['options' => ['enctype'=>'multipart/form-data']]);

    $images = $model->getImageUrl('images');
    $imagePreviews = [];
    foreach ($images as $image) {
        $imagePreviews[] = Html::img($image, ['class'=>'file-preview-image']);
    }
    $files = $model->getImageUrl('files');
    $filePreviews = [];
    if ($files !== ['/404.png']) {
        foreach ($files as $key => $file) {
            $filePreviews[] = Html::a(Yii::t('admin', 'File') . ' ' . ($key + 1), $file);
        }
    }
    ?>
    <?= $form->field($model, 'status')->dropDownList($model->getStatusArray(), ['prompt' => Yii::t('admin', 'Select Status')]) ?>
    <?= $form->field($model, 'client_email')->textInput(['maxlength' => 128]) ?>
    <?= $form->field($model, 'skype')->textInput(['maxlength' => 128]) ?>
    <?= $form->field($model, 'telephone')->textInput(['maxlength' => 128]) ?>
    <?= $form->field($model, 'company_name')->textInput(['maxlength' => 255]) ?>
    <?= $form->field($model, 'site_link')->textInput(['maxlength' => 255]) ?>
    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>
    <?= $form->field($model, 'composition')->dropDownList($model->getCompositionArray(), ['prompt' => Yii::t('admin', 'Select Composition')]) ?>
    <?= $form->field($model, 'tariff')->dropDownList($model->getTariffArray(), ['prompt' => Yii::t('admin', 'Select Tariff')]) ?>
    <?= $form->field($model, 'logo_variants')->textInput(['maxlength' => 10]) ?>
    <?= $form->field($model, 'hilarity')->widget(Slider::classname(), [
        'pluginOptions'=>[
            'min' => 0,
            'max' => 100,
            'step' => 1,
        ]
    ]); ?>
    <?= $form->field($model, 'modernity')->widget(Slider::classname(), [
        'pluginOptions'=>[
            'min' => 0,
            'max' => 100,
            'step' => 1,
        ]
    ]); ?>
    <?= $form->field($model, 'minimalism')->widget(Slider::classname(), [
        'pluginOptions'=>[
            'min' => 0,
            'max' => 100,
            'step' => 1,
        ]
    ]); ?>
    <?= $form->field($model, 'money_earning')->textarea(['rows' => 6]) ?>
    <?= $form->field($model, 'who_clients')->textarea(['rows' => 6]) ?>
    <?= $form->field($model, 'company_strength')->textarea(['rows' => 6]) ?>
    <?= $form->field($model, 'who_competitors')->textarea(['rows' => 6]) ?>
    <?= $form->field($model, 'coupon_id')->dropDownList(ArrayHelper::map(Coupon::find()->all(), 'id', 'code'), ['prompt' => '-'.Yii::t('admin', 'Select Coupon').'-']) ?>
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
            'initialPreview' => $imagePreviews,
            'maxFileCount' => 10,
            'maxFileSize' => 1024,
            'msgSizeTooLarge' => Yii::t('app', 'File "{name}" (<b>{size} KB</b>) exceeds maximum allowed upload size of <b>{maxSize} KB</b>. Please retry your upload!'),
            'msgFilesTooMany' => Yii::t('app', 'Number of files selected for upload <b>({n})</b> exceeds maximum allowed limit of <b>{m}</b>. Please retry your upload!'),
            'msgInvalidFileType' => Yii::t('app', 'Invalid type for file "{name}". Only "{types}" files are supported.'),
            'msgInvalidFileExtension' => Yii::t('app', 'Invalid extension for file "{name}". Only "{extensions}" files are supported.'),
            'msgLoading' => Yii::t('app', 'Loading file {index} of {files} &hellip;'),
            'msgProgress' => Yii::t('app', 'Loading file {index} of {files} - {name} - {percent}% completed.'),
        ]
    ]); ?>
    <?= $form->field($model, 'files[]')->widget(FileInput::classname(), [
        'options'=> [
//            'accept' => 'image/*',
            'multiple' => true,
        ],
        'pluginOptions' => [
            'showUpload' => false,
            'showRemove' => false,
            'showCaption' => false,
//            'allowedFileExtensions' => ['jpg','gif','png'],
            'initialPreview' => $filePreviews,
            'maxFileCount' => 10,
            'maxFileSize' => 1024,
            'msgSizeTooLarge' => Yii::t('app', 'File "{name}" (<b>{size} KB</b>) exceeds maximum allowed upload size of <b>{maxSize} KB</b>. Please retry your upload!'),
            'msgFilesTooMany' => Yii::t('app', 'Number of files selected for upload <b>({n})</b> exceeds maximum allowed limit of <b>{m}</b>. Please retry your upload!'),
            'msgInvalidFileType' => Yii::t('app', 'Invalid type for file "{name}". Only "{types}" files are supported.'),
            'msgInvalidFileExtension' => Yii::t('app', 'Invalid extension for file "{name}". Only "{extensions}" files are supported.'),
            'msgLoading' => Yii::t('app', 'Loading file {index} of {files} &hellip;'),
            'msgProgress' => Yii::t('app', 'Loading file {index} of {files} - {name} - {percent}% completed.'),
        ]
    ]); ?>
<!--    --><?php //echo $form->field($model, 'color_scheme')->widget(ColorInput::classname(), [
//        'options' => [
//            'placeholder' => Yii::t('admin', 'Select color ...'),
//            'readonly' => true
//        ],
//    ]); ?>
    <?= $form->field($model, 'users')->widget(Select2::classname(), [
        'data' => ArrayHelper::map(User::find()->orderBy('username')->asArray()->all(), 'id', 'username'),
        'options' => [
            'placeholder' => Yii::t('admin', 'Select Designers ...'),
            'class'=>'form-control',
            'multiple' => true
        ],
    ]); ?>
    <?= $form->field($model, 'options')->widget(Select2::classname(), [
        'data' => ArrayHelper::map(Option::find()->asArray()->all(), 'id', 'name'),
        'options' => [
            'placeholder' => Yii::t('admin', 'Select Options ...'),
            'class'=>'form-control',
            'multiple' => true
        ],
    ]); ?>
    <?= $form->field($model, 'portfolios')->widget(Select2::classname(), [
        'data' => ArrayHelper::map(Portfolio::find()->asArray()->all(), 'id', 'title'),
        'options' => [
            'placeholder' => Yii::t('admin', 'Select Portfolios ...'),
            'class'=>'form-control',
            'multiple' => true
        ],
    ]); ?>
    <?= $form->field($model, 'price_no_disc')->textInput(['maxlength' => 12]) ?>
    <?= $form->field($model, 'price')->textInput(['maxlength' => 12]) ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('admin', 'Create') : Yii::t('admin', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>