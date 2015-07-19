<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

$this->title = Yii::t('happycode', 'Add Admin');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="alert alert-warning">
        <?= \Yii::t(
            'happycode',
            'Think twice before giving admin access to someone, remember that she/he will have same privileges as you!'
        ); ?>
    </div>

    <p>Please fill out the following fields to login:</p>

    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'options' => ['class' => 'form-horizontal'],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-5\">{input}\n{hint}</div>\n<div class=\"col-lg-6\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
    ]); ?>

    <?= $form->field($model, 'email') ?>
    <?= $form->field($model, 'message', [
        'template' => "{label}\n<div class=\"col-lg-11\">{input}\n{hint}\n{error}</div>"
    ])->textarea()->hint(
        Yii::t('happycode', 'You can send additional message to new admin using this field.')
    ); ?>

    <div class="form-group">
        <div class="col-lg-offset-1 col-lg-11">
            <?= Html::submitButton('Add', ['class' => 'btn btn-primary', 'name' => 'add-button']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
</div>
