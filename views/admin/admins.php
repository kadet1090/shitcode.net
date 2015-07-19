<?php
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $admins \yii\data\ActiveDataProvider */

$this->title = Yii::t('happycode', 'Admins list');
$this->params['breadcrumbs'][] = $this->title;

echo GridView::widget([
    'dataProvider' => $admins,
    'columns' => [
        ['class' => \yii\grid\SerialColumn::className()],
        'email',
        'created',
        [
            'attribute' => 'created_by',
            'format' => 'html',
            'value' => function ($model) {
                if(!isset($model->createdBy))
                    return Yii::t('happycode', 'root');

                return $model->createdBy->email;
            }
        ],
        'last_access'
    ]
]);