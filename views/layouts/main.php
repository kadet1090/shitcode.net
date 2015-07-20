<?php
use app\helpers\AlertHelper;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
$hljs = nezhelskoy\highlight\HighlightAsset::register($this);
\yii\bootstrap\BootstrapPluginAsset::register($this);

$this->registerJs('window.highlightBase = "' . Yii::$app->assetManager->getAssetUrl($hljs, null) . '"');
$affix = <<<JS
$('#nav-affix').affix({
    offset: {
        top: 50
    }
})
JS;

$this->registerJs($affix);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>

<?php $this->beginBody() ?>
    <div class="wrap">
        <div class="banner">
            <div id="nav-affix">
                <div class="container-fluid">
                    <div class="container">
                        <a class="pull-left brand" href="/">shitcode</a>
                        <ul class="nav nav-pills pull-right">
                            <li <?php if(Yii::$app->requestedAction->uniqueId == 'site/latest'): ?>class="active"<?php endif;?>>
                                <?= Html::a(Yii::t('happycode', 'Latest'), ['site/latest']) ?>
                            </li>
                            <li <?php if(Yii::$app->requestedAction->uniqueId == 'site/index'): ?>class="active"<?php endif;?>>
                                <?= Html::a(Yii::t('happycode', 'Browse'), ['site/index']) ?>
                            </li>
                            <li <?php if(Yii::$app->requestedAction->uniqueId == 'site/best'): ?>class="active"<?php endif;?>>
                                <?= Html::a(Yii::t('happycode', 'Top'), ['site/best']) ?>
                            </li>
                            <li <?php if(Yii::$app->requestedAction->uniqueId == 'site/worst'): ?>class="active"<?php endif;?>>
                                <?= Html::a(Yii::t('happycode', 'Worst'), ['site/worst']) ?>
                            </li>
                            <li class="add <?php if(Yii::$app->requestedAction->uniqueId == 'site/add'): ?>active<?php endif;?>">
                                <?= Html::a(
                                    Yii::t('happycode', 'Add').' '.\app\helpers\BootstrapHelper::glyphicon('plus'),
                                    ['site/add']
                                ) ?>
                            </li>
                            <li class="settings dropdown">
                                <a class="dropdown-toggle" href="#" data-toggle="dropdown" id="navLogin"><?= \app\helpers\BootstrapHelper::glyphicon('cog') ?></a>
                                <div class="dropdown-menu dropdown-menu-right" style="padding:15px; width: 350px;">
                                    <?= Html::beginForm(['site/save-settings'], 'post', ['id' => 'settings-form']) ?>
                                        <div class="form-group">
                                            <label for="theme-settings"><?= Yii::t('happycode', 'Highlight theme:'); ?></label>
                                            <select name="highlight-style" id="theme-settings" class="form-control">
                                                <?php foreach(Yii::$app->params['highlight-styles'] as $style => $name):?>
                                                    <option value="<?=$style?>"
                                                            <?php if($style == Yii::$app->userSettings->highlightStyle): ?>selected="selected"<?php endif; ?>>
                                                        <?= $name ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="ace-settings"><?= Yii::t('happycode', 'Editor theme:'); ?></label>
                                            <select name="ace-style" id="ace-settings" class="form-control">
                                                <?php foreach(Yii::$app->params['ace-styles'] as $style => $name):?>
                                                    <option value="<?=$style?>"
                                                            <?php if($style == Yii::$app->userSettings->aceStyle): ?>selected="selected"<?php endif; ?>>
                                                        <?= $name ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <button class="btn btn-block btn-primary">Save</button>
                                    <?= Html::endForm(); ?>
                                </div>
                            </li>
                            <?php if(!Yii::$app->user->isGuest): ?>
                            <li class="dropdown">
                                <a class="dropdown-toggle" href="#" data-toggle="dropdown">
                                    admin <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li><a href="<?= \yii\helpers\Url::to(['admin/pending']) ?>"><?= Yii::t('happycode', 'Pending'); ?> <span class="badge"><?= \app\models\Code::countPending() ?></span></a></li>
                                    <li><a href="<?= \yii\helpers\Url::to(['admin/add-admin']) ?>"><?= Yii::t('happycode', 'Add admin'); ?></a></li>
                                    <li><a href="<?= \yii\helpers\Url::to(['admin/change-password']) ?>"><?= Yii::t('happycode', 'Change password'); ?></a></li>
                                    <li><a href="<?= \yii\helpers\Url::to(['admin/logout']) ?>"><?= Yii::t('happycode', 'Logout'); ?></a></li>
                                </ul>
                            </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
            <?= AlertHelper::render(); ?>
            <?= $content ?>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
            <p class="pull-left">&copy; My Company <?= date('Y') ?>, <?= Yii::powered() ?></p>
        </div>
    </footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
