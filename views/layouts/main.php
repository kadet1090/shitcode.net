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
        <?= $this->render('banner'); ?>
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
            <p class="pull-left">&copy; Kadet <?= date('Y') ?>, <?= Yii::powered() ?></p>
            <p class="pull-right"><?= Html::a('Admin', ['admin/login']) ?></p>
        </div>
    </footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
