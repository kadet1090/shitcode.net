<?php
    /** @var \app\models\Code $model  */
    $parsedown = Parsedown::instance();
?>
<div class="paste panel panel-default">
    <div class="panel-heading">
        <a href="#" class="title">#<?= $model->id ?> <?= $model->title ?></a>
        <a href="#" class="language pull-right"><?= array_search($model->language, Yii::$app->params['languages']) ?></a>
    </div>
    <div class="panel-body">
        <pre><code class="lang-<?= $model->language ?>"><?= htmlspecialchars($model->code) ?></code></pre>
        <?php if(!empty($model->description)): ?><div class="description"><?= $parsedown->parse($model->description); ?></div><?php endif; ?>
    </div>
    <div class="panel-footer">
        <div class="btn-group actions">
            <a href="#" class="btn btn-success">
                <span class="glyphicon glyphicon-thumbs-up"></span>
            </a>
            <a href="#" class="btn btn-danger">
                <span class="glyphicon glyphicon-thumbs-down"></span>
            </a>
            <a href="#" class="btn btn-info">
                <span class="glyphicon glyphicon-comment"></span>
                15
            </a>
        </div>
        <div class="author pull-right">
            <?= Yii::t('happycode', 'By <em>{author}</em>', ['author' => $model->author ]) ?>,
            <?= $model->added_at ?>
        </div>
    </div>
</div>