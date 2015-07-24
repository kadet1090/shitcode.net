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

$this->registerMetaTag(['name' => 'keywords', 'content' => implode(', ', Yii::$app->params["keywords"])], 'keywords');
$this->registerMetaTag(['name' => 'description', 'content' => Yii::$app->params["description"]], 'description');
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?> - <?= Yii::$app->name?></title>
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
            <p class="pull-left">&copy; Shitcode.net <?= date('Y') ?>, <?= Yii::powered() ?></p>
            <p class="pull-right">
                <a href="https://github.com/kadet1090/shitcode.net">GitHub</a> &bullet;
                <?= Html::a('About', ['site/about']) ?> &bullet;
                <?= Html::a('Admin', ['admin/login']) ?>
            </p>
        </div>
    </footer>

<?php $this->endBody() ?>
    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-65571975-1', 'auto');
        ga('send', 'pageview');

    </script>
</body>
</html>
<?php $this->endPage() ?>
