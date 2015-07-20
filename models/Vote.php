<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "votes".
 *
 * @property string $id
 * @property string $snippet_id
 * @property integer $ip
 * @property string $fingerprint
 * @property integer $vote
 */
class Vote extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'votes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['snippet_id', 'ip', 'vote'], 'integer'],
            [['fingerprint'], 'string', 'max' => 80],
            [['ip', 'fingerprint', 'snippet_id'], 'unique', 'targetAttribute' => ['ip', 'fingerprint', 'snippet_id'], 'message' => 'The combination of Snippet ID, Ip and Fingerprint has already been taken.']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('happycode', 'ID'),
            'snippet_id' => Yii::t('happycode', 'Snippet ID'),
            'ip' => Yii::t('happycode', 'Ip'),
            'fingerprint' => Yii::t('happycode', 'Fingerprint'),
            'vote' => Yii::t('happycode', 'Vote'),
        ];
    }
}
