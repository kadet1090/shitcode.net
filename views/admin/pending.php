<?php
use app\models\Code;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $pending \yii\data\ActiveDataProvider */

$this->title = Yii::t('happycode', 'Pending pastes');
$this->params['breadcrumbs'][] = $this->title;

$parsedown = Parsedown::instance();
?>
<div class="alerts">

</div>
<?php /** @var Code $paste */ foreach($pending->models as $paste): ?>
    <div class="well" id="paste-<?=$paste->id?>">
        <h4><strong>#<?= $paste->id ?></strong> <?= $paste->title ?></h4>
        <div class="row">
            <div class="col-md-4">
                <strong><?= $paste->getAttributeLabel('language') ?>:</strong> <?= $paste->language ?> <br />

                <?php if(!empty($paste->author)): ?>
                    <strong><?= $paste->getAttributeLabel('author') ?>:</strong> <?= $paste->author ?> <br />
                <?php endif; ?>
                <?php if(!empty($paste->description)): ?>
                    <hr />
                    <?= $parsedown->parse($paste->description) ?>
                <?php endif; ?>

                <div class="btn-group pull-right" role="group" aria-label="Actions">
                    <a class="btn btn-success accept-action"
                       data-id="<?= $paste->id ?>"
                       href="<?= \yii\helpers\Url::to(['admin/change-status', 'id' => $paste->id, 'status' => 1]) ?>">
                        <span aria-hidden="true" class="glyphicon glyphicon-ok"></span> Accept
                    </a>
                    <a class="btn btn-danger decline-action"
                       data-id="<?= $paste->id ?>"
                       href="<?= \yii\helpers\Url::to(['admin/change-status', 'id' => $paste->id, 'status' => -1]) ?>">
                        <span aria-hidden="true" class="glyphicon glyphicon-remove"></span> Decline
                    </a>
                </div>
            </div>
            <div class="col-md-8">
                <pre><code class="lang-<?= $paste->language ?>"><?= $paste->code ?></code></pre>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<?php
$url = \yii\helpers\Url::to(['admin/change-status']);

$script = <<< JS
$('.accept-action, .decline-action').on('click', function(e) {
    $.ajax({
        url: '$url',
        data: {
            id: $(this).data('id'),
            status: $(this).hasClass('decline-action') ? -1 : 1
        },
        success: function(data) {
            $('<div class="alert alert-success alert-dismissible" id="alert-' + data.id + '">' +
                '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
                data.message +
            '</div>').hide().appendTo('.alerts').slideDown();

            $('#paste-' + data.id).slideUp(500, function() { $(this).remove(); });
        }
    });

    e.preventDefault();
});
JS;
$this->registerJs($script);
