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
Accept or Decline it.