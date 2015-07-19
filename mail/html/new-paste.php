<?php
/** @var $paste \app\models\Code */
?>

New paste <strong>#<?= $paste->id ?></strong> Was added from ip: <em><?= long2ip($paste->ip) ?></em>. <br/>
<br/>
<b>Title: </b> <?= $paste->title ?> <br/>
<b>Description: </b> <?= $paste->description ?> <br/>
<b>Author: </b> <?= $paste->author ?> <br/>
<b>Language: </b> <?= $paste->language ?> <br/>

<b>Code: </b><br/>
<pre>
<?= $paste->code ?>
</pre>

<br/>
You can:<br/>
<a href="<?= \yii\helpers\Url::to(['admin/change-status', 'id' => $paste->id, 'status' => 1], true) ?>">Accept</a> or
<a href="<?= \yii\helpers\Url::to(['admin/change-status', 'id' => $paste->id, 'status' => -1], true) ?>">Decline it</a>.