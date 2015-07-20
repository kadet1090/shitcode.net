<?php
/* @var $this yii\web\View */
use app\widgets\Paste;

/* @var $models \yii\data\ActiveDataProvider */
/* @var $languages Array */

$this->title = 'ShitCode';
$counts = array_map(function($l) { return $l['count']; }, $languages);
$max = max($counts);

?>
<div class="alerts fixed"></div>
<div class="container pastes">
    <ul class="languages clearfix">
        <li <?php if(!isset($_GET['language'])): ?>class="selected"<?php endif;?>>
            <a href="<?= \yii\helpers\Url::to([Yii::$app->requestedAction->uniqueId]) ?>"
               style="font-size: 26pt">
                <?= Yii::t('happycode', 'All') ?>
                <span class="badge"><?= array_sum($counts); ?></span>
            </a>
        </li>
        <?php foreach($languages as $lang): ?>
            <li <?php if(isset($_GET['language']) && $lang['language'] == $_GET['language']): ?>class="selected"<?php endif;?>>
                <a href="<?= \yii\helpers\Url::to([Yii::$app->requestedAction->uniqueId, 'language' => $lang['language']]) ?>"
                   style="font-size: <?= 14 + 8*($lang['count']/$max) ?>pt">
                    <?= $lang['label'] ?> <span class="badge"><?= $lang['count'] ?></span>
                </a>
            </li>
        <?php endforeach;?>
    </ul>

    <?php foreach($models->models as $model)
        echo Paste::widget(['model' => $model, 'actions' => [
            \yii\helpers\Html::a('<span class="glyphicon glyphicon-thumbs-up"></span>', ['site/vote', 'id' => $model->id, 'vote' => 1], [
                'class' => 'btn btn-success vote-up'.($model->canVote ? '' : ' disabled')
            ]),
            \yii\helpers\Html::a('<span class="glyphicon glyphicon-thumbs-down"></span>', ['site/vote', 'id' => $model->id, 'vote' => -1], [
                'class' => 'btn btn-danger vote-down'.($model->canVote ? '' : ' disabled')
            ]),
            \yii\helpers\Html::a('Comments', ['site/paste', 'id' => $model->id, '#' => 'disqus_thread'], ['class' => 'btn btn-info']),
        ]]);
    ?>

    <?= \yii\widgets\LinkPager::widget(['pagination' => $models->pagination]); ?>
</div>

<?php
$url = \yii\helpers\Url::to(['admin/vote']);

$script = <<< JS
$('.vote-up, .vote-down').on('click', function(e) {
    $.ajax({
        url: $(this).attr('href')
    }).always(function(data) {
        var type = 'success';
        if(typeof data.responseJSON !== "undefined") {
            data = data.responseJSON;
            type = 'danger';
        }

        var alert = $('<div class="alert alert-' + type + ' alert-dismissible" id="alert-' + data.id + '">' +
            '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
            data.message +
        '</div>').hide().appendTo('.alerts').slideDown();

        setTimeout(function() {
            alert.slideUp(250, function() {
                alert.remove();
            })
        }, 1500);
    });

    e.preventDefault();
});
JS;
$this->registerJs($script);
?>

<script type="text/javascript">
    /* * * CONFIGURATION VARIABLES * * */
    var disqus_shortname = 'shit-code';

    /* * * DON'T EDIT BELOW THIS LINE * * */
    (function () {
        var s = document.createElement('script'); s.async = true;
        s.type = 'text/javascript';
        s.src = '//' + disqus_shortname + '.disqus.com/count.js';
        (document.getElementsByTagName('HEAD')[0] || document.getElementsByTagName('BODY')[0]).appendChild(s);
    }());
</script>