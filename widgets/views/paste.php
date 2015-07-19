<?php
    /** @var \app\models\Code $model  */
    $parsedown = Parsedown::instance();
?>
<div class="paste panel panel-default" id="paste-<?=$model->id?>">
    <div class="panel-heading">
        <a href="<?= \yii\helpers\Url::to(['site/paste', 'id' => $model->id ])?>" class="title">#<?= $model->id ?> <?= $model->title ?></a>
        <a href="<?= \yii\helpers\Url::to([Yii::$app->requestedAction->uniqueId, 'language' => $model->language]) ?>" class="language pull-right"><?= array_search($model->language, Yii::$app->params['languages']) ?></a>
    </div>
    <div class="panel-body">
        <pre><code class="lang-<?= $model->language ?>"><?= htmlspecialchars($model->code) ?></code></pre>
        <?php if(!empty($model->description)): ?><div class="description"><?= $parsedown->parse($model->description); ?></div><?php endif; ?>
    </div>
    <div class="panel-footer">
        <div class="btn-group actions">
            <?php foreach($actions as $action) echo $action ?>
        </div>
        <div class="author pull-right">
            <?= Yii::t('happycode', 'By <em>{author}</em>', ['author' => $model->author ]) ?>,
            <?= $model->added_at ?>
        </div>
    </div>
</div>