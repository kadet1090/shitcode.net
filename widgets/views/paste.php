<?php
/** @var \app\models\Code $model  */
$parsedown = Parsedown::instance();
$class = '';
if($model->score > 0) $class = 'text-success';
if($model->score < 0) $class = 'text-danger';
?>
<div class="paste panel panel-default" id="paste-<?=$model->id?>">
    <div class="panel-heading">
        <a href="<?= \yii\helpers\Url::to(['site/paste', 'id' => $model->id ])?>" class="title">#<?= $model->id ?> <?= htmlspecialchars($model->title) ?></a>
        <a href="<?= \yii\helpers\Url::to([Yii::$app->requestedAction->uniqueId, 'language' => $model->language]) ?>" class="language pull-right"><?= Yii::$app->languages->hljs[$model->language] ?></a>
        <strong class="score pull-right <?= $class?>"><?= ($model->score > 0 ? '+' : '').$model->score ?></strong>
    </div>
    <div class="panel-body">
        <pre><code class="hljs <?= $model->language ?>"><?= htmlspecialchars($model->code) ?></code></pre>
        <?php if(!empty($model->description)): ?><div class="description"><?= $parsedown->parse($model->description); ?></div><?php endif; ?>
    </div>
    <div class="panel-footer post">
        <div class="row">
            <div class="col-md-6">
                <div class="actions-wrapper">
                    <div class="btn-group actions clearfix">
                        <?php foreach($actions as $action) echo $action ?>
                    </div>
                </div>
            </div>
            <div class="author col-md-6">
                <?= Yii::t('happycode', 'By <em>{author}</em>', ['author' => !empty($model->author) ? htmlspecialchars($model->author) : Yii::t('happycode', 'Anonymous') ]) ?>,
                <?= $model->added_at ?>
            </div>
        </div>
    </div>
</div>