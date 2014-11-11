<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\modules\admin\models\LoginForm */

$this->title = Yii::t('admin', 'Вход');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <div class="row">
        <div class="col-md-4">
            &nbsp;
        </div>
        <div class="col-md-4">
            <h1><?= Html::encode($this->title) ?></h1>
            <p><?= Yii::t('admin', 'Please enter your credentials to login:'); ?></p>
            <?php $form = ActiveForm::begin([
                'id' => 'login-form',
            ]); ?>
            <?= $form->field($model, 'username') ?>
            <?= $form->field($model, 'password')->passwordInput() ?>
            <?= $form->field($model, 'rememberMe')->checkbox() ?>
            <div class="form-group">
                <?= Html::submitButton(Yii::t('admin', 'Войти'), ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
        <div class="col-md-4">
            &nbsp;
        </div>
    </div>
</div>