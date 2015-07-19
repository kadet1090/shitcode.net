<?php
/* @var $this yii\web\View */
use app\widgets\Paste;

/* @var $models \yii\data\ActiveDataProvider */

$this->title = 'ShitCode';
?>
<div class="container pastes">
    <?php foreach($models->models as $model)
        echo Paste::widget(['model' => $model]);
    ?>
</div>
