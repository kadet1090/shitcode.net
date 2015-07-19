<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "code".
 *
 * @property string $id
 * @property string $ip
 * @property string $author
 * @property string $title
 * @property string $description
 * @property string $language
 * @property string $code
 * @property int $approved
 * @property integer $approved_by
 * @property string $added_at
 *
 * @property Admin $approvedBy
 */
class Code extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'code';
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
            'id' => Yii::t('happycode', 'ID'),
            'ip' => Yii::t('happycode', 'IP Address'),
            'author' => Yii::t('happycode', 'Author'),
            'title' => Yii::t('happycode', 'Title'),
            'description' => Yii::t('happycode', 'Description'),
            'language' => Yii::t('happycode', 'Language'),
            'code' => Yii::t('happycode', 'Code'),
            'approved' => Yii::t('happycode', 'Approved'),
            'approved_by' => Yii::t('happycode', 'Approved By'),
            'added_at' => Yii::t('happycode', 'Added At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApprovedBy()
    {
        return $this->hasOne(Admin::className(), ['id' => 'approved_by']);
    }
}
