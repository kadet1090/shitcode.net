<?php
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\AddCodeForm */

$this->title                   = Yii::t('happycode', 'Add Paste');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="site-contact">
    <h1><?= Html::encode($this->title) ?></h1>

    <div>
        <?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>
        <div class="row">
            <div class="col-md-8">
                <?= $form->field($model, 'title') ?>
            </div>
            <div class="col-md-4">
                <div class="form-group field-addcodeform-language required">
                    <label class="control-label" for="addcodeform-language"><?= $model->getAttributeLabel('language'); ?></label>
                    <select id="addcodeform-language" class="form-control" name="AddCodeForm[language]">
                        <?php foreach(Yii::$app->languages->languages as $lang): ?>
                            <option data-ace-mode="<?= $lang['ace'] ?>"
                                    <?php if($lang['hljs'] == $model->language): ?>selected="selected"<?php endif; ?>
                                    value="<?= $lang['hljs'] ?>">
                                <?= $lang['label'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <p class="help-block help-block-error"></p>
                </div>
            </div>
        </div>
        <?= $form->field($model, 'code')->widget(trntv\aceeditor\AceEditor::className(), [
            'mode'  => $model->language,
            'theme' => Yii::$app->userSettings->aceStyle
        ])->hint(Yii::t('happycode',
            'You can paste whatever shitty code you want, remember that this code will be (hopefully) available to everyone!'
        )) ?>
        <?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
            'template' => '<div class="row"><div class="col-lg-2">{image}</div><div class="col-lg-3">{input}</div></div>',
        ]) ?>
        <?= $form->field($model, 'author')->hint(Yii::t('happycode',
            'Fill that field if you want people to know who is an author of this paste.'
        )) ?>
        <?= $form->field($model, 'description')->textArea(['rows' => 3])->hint(Yii::t('happycode',
            'You can describe your paste with few words, if it needs some explanation or context. You can use {markdown}.', [
                'markdown' => Html::a('Github flavored markdown', 'https://help.github.com/articles/github-flavored-markdown/')
            ]
        )) ?>
        <div class="for m-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
<?php
$this->registerJs(<<<'JS'
window.aceeditor = aceeditor_w0;

jQuery('#addcodeform-language').selectize({
    onInitialize: function () {
        var s = this;
        this.revertSettings.$children.each(function () {
            $.extend(s.options[this.value], $(this).data());
        });
    },
    onChange: function(e){
        aceeditor_w0.getSession().setMode('ace/mode/' + this.options[e].aceMode);
    }
});
JS
);
?>