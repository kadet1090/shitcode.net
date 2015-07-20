<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "code".
 *
 * @property string  $id
 * @property string  $ip
 * @property string  $author
 * @property string  $title
 * @property string  $description
 * @property string  $language
 * @property string  $code
 * @property integer $approved
 * @property integer $approved_by
 * @property string  $added_at
 * @property integer $score
 *
 * @property Admin   $approvedBy
 */
class Code extends \yii\db\ActiveRecord
{
    protected static $_voted;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'code';
    }

    public static function recalculateScore($id = null)
    {
        $sql = 'UPDATE `code` SET `score` = (
	        SELECT SUM(vote) FROM `votes` WHERE `votes`.`snippet_id` = `code`.`id` GROUP BY `votes`.`snippet_id`
        )';

        if ($id !== null) {
            $sql .= ' WHERE `code`.`id` = :id';
        }

        Yii::$app->db->createCommand($sql, $id === null ? [] : ['id' => $id])->execute();
    }

    public static function getLanguages()
    {
        $labels = array_flip(Yii::$app->params['languages']);

        $count = self::find()
            ->select('language, COUNT(*) as `count`')
            ->where(['approved' => 1])
            ->groupBy('language')
            ->asArray()
            ->all();

        return array_map(function ($language) use ($labels) {
            return [
                'label'    => $labels[$language['language']],
                'language' => $language['language'],
                'count'    => $language['count'],
            ];
        }, $count);
    }

    public static function countPending()
    {
        static $count = null;

        return $count === null ? $count = Code::find()->where(['approved' => 0])->count() : $count;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ip'], 'integer'],
            [['approved'], 'integer'],
            [['description', 'code'], 'string'],
            [['added_at', 'approved_by'], 'safe'],
            [['author'], 'string', 'max' => 45],
            [['title'], 'string', 'max' => 200],
            [['language'], 'string', 'max' => 24]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'          => Yii::t('happycode', 'ID'),
            'ip'          => Yii::t('happycode', 'IP Address'),
            'author'      => Yii::t('happycode', 'Author'),
            'title'       => Yii::t('happycode', 'Title'),
            'description' => Yii::t('happycode', 'Description'),
            'language'    => Yii::t('happycode', 'Language'),
            'code'        => Yii::t('happycode', 'Code'),
            'approved'    => Yii::t('happycode', 'Approved'),
            'approved_by' => Yii::t('happycode', 'Approved By'),
            'added_at'    => Yii::t('happycode', 'Added At'),
        ];
    }

    public function getCanVote()
    {
        if (empty(self::$_voted)) self::_loadVoted();

        return !in_array($this->id, self::$_voted);
    }

    private static function _loadVoted()
    {
        self::$_voted = array_map(function ($a) {
            return $a['snippet_id'];
        }, Vote::find()->select('snippet_id')->where([
            'ip'          => ip2long(Yii::$app->request->userIP),
            'fingerprint' => md5(Yii::$app->request->userAgent)
        ])->asArray()->all());
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApprovedBy()
    {
        return $this->hasOne(Admin::className(), ['id' => 'approved_by']);
    }
}
