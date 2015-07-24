<?php
use yii\helpers\Html;

/** @var $this yii\web\View */
/** @var $model \app\models\Code */

$this->title = 'Paste';
$this->params['breadcrumbs'][] = $this->title;

$this->registerJsFile('js/voting.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerMetaTag(['name' => 'keywords', 'content' => implode(', ', Yii::$app->params["keywords"] + [$model->language])], 'keywords');
?>
<?= \app\widgets\Paste::widget(['model' => $model, 'actions' => [
    \yii\helpers\Html::a('<span class="glyphicon glyphicon-thumbs-up"></span>', ['site/vote', 'id' => $model->id, 'vote' => 'up'], [
        'class' => 'btn btn-success vote-up'.($model->canVote ? '' : ' disabled'),
        'rel' => 'nofollow',
    ]),
    \yii\helpers\Html::a('<span class="glyphicon glyphicon-thumbs-down"></span>', ['site/vote', 'id' => $model->id, 'vote' => 'down'], [
        'class' => 'btn btn-danger vote-down'.($model->canVote ? '' : ' disabled'),
        'rel' => 'nofollow',
    ]),
]]) ?>

<div id="disqus_thread"></div>
<script type="text/javascript">
    /* * * CONFIGURATION VARIABLES * * */
    var disqus_shortname = 'shit-code';

    /* * * DON'T EDIT BELOW THIS LINE * * */
    (function() {
        var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
        dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
        (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
    })();
</script>
<noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript" rel="nofollow">comments powered by Disqus.</a></noscript>
