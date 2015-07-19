<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class AddCodeForm extends Model
{
    public $author;
    public $description;
    public $title;
    public $code;
    public $language = 'php';

    public $verifyCode;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['code', 'language'], 'required'],
            [['author', 'description', 'title'], 'safe'],
            [['author'], 'string', 'max' => 45],
            [['title'], 'string', 'max' => 200],
            [['language'], 'string', 'max' => 24],
            // verifyCode needs to be entered correctly
            ['verifyCode', 'captcha'],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'verifyCode' => Yii::t('happycode', 'Verification Code'),
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     * @return boolean whether the model passes validation
     */
    public function add()
    {
        if ($this->validate()) {
            $code = new Code([
                'code' => $this->code,
                'language' => $this->language,
                'author' => $this->author,
                'title' => $this->title,
                'description' => $this->description,
                'approved' => 0,
                'ip' => ip2long(Yii::$app->request->userIP)
            ]);

            if(!$code->save()) return false;

            $this->sendMails($code);
            return true;
        } else {
            return false;
        }
    }

    public function sendMails($code) {
        $admins = Admin::find()->where(['inform' => 1])->all();
        $mails = array_map(function($element) { return $element->email; }, $admins);

        Yii::$app->mailer
            ->compose(['html' => 'html/new-paste', 'text' => 'text/new-paste'], ['paste' => $code])
            ->setTo($mails)
            ->setFrom('no-reply@'.Yii::$app->request->serverName)
            ->setSubject("New paste #".$code->id)
            ->send();
    }
}
