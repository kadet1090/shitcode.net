<?php
use app\models\Code;
use app\widgets\Paste;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $pending \yii\data\ActiveDataProvider */

$this->title = Yii::t('happycode', 'Pending pastes');
$this->params['breadcrumbs'][] = $this->title;

$parsedown = Parsedown::instance();
?>
<div class="alerts">

</div>
<?php /** @var Code $paste */ foreach($pending->models as $paste) {
    echo Paste::widget(['model' => $paste, 'actions' => [
        \yii\helpers\Html::a(
            '<span aria-hidden="true" class="glyphicon glyphicon-ok"></span> Approve',
            ['admin/change-status', 'id' => $paste->id, 'status' => 1],
            [
                'class' => 'btn btn-success accept-action',
                'data-id' => $paste->id
            ]
        ),
        \yii\helpers\Html::a(
            '<span aria-hidden="true" class="glyphicon glyphicon-remove"></span> Decline',
            ['admin/change-status', 'id' => $paste->id, 'status' => -1],
            [
                'class' => 'btn btn-danger decline-action',
                'data-id' => $paste->id
            ]
        ),
    ]]);
} ?>

<?= \yii\widgets\LinkPager::widget(['pagination' => $pending->pagination]); ?>

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
