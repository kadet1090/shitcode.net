<?php
/* @var $this yii\web\View */
use app\widgets\Paste;

/* @var $models \yii\data\ActiveDataProvider */

$this->title = 'ShitCode';
?>
<div class="container pastes">
    <?php foreach($models->models as $model)
        echo Paste::widget(['model' => $model, 'actions' => [
            \yii\helpers\Html::a('<span class="glyphicon glyphicon-thumbs-up"></span>', '#', ['class' => 'btn btn-success']),
            \yii\helpers\Html::a('<span class="glyphicon glyphicon-thumbs-down"></span>', '#', ['class' => 'btn btn-danger']),
            \yii\helpers\Html::a('Comments', ['site/paste', 'id' => $model->id, '#' => 'disqus_thread'], ['class' => 'btn btn-info']),
        ]]);
    ?>
</div>

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