<?php
/** @var $paste \app\models\Code */
?>
New paste #<?= $paste->id ?> Was added from ip: <?= long2ip($paste->ip) ?>.

Title: <?= $paste->title ?>
Description: <?= $paste->description ?>
Author: <?= $paste->author ?>
Language: <?= $paste->language ?>

Code:
<?= $paste->code ?>

You can:
Accept (<?= \yii\helpers\Url::to(['admin/change-status', 'id' => $paste->id, 'status' => 1], true) ?>) or
Decline (<?= \yii\helpers\Url::to(['admin/change-status', 'id' => $paste->id, 'status' => -1], true) ?>) it.