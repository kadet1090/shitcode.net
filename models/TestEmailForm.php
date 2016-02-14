<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 */
class TestEmailForm extends Model
{
    public $email;
    public $message;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['email'], 'email'],
            [['message'], 'safe']
        ];
    }

    /**
     * Sends test message
     * @return boolean whether was send or not
     */
    public function send()
    {
        if ($this->validate()) {
            $host = Yii::$app->request->serverName;

            $content = <<<MAIL
Test mail from {$host}.
MAIL;
            if(!empty($this->message)) {
                $content .= PHP_EOL.PHP_EOL.'PS '.$this->message;
            }

            return Yii::$app->mailer
                ->compose()
                ->setTo($this->email)
                ->setFrom(Yii::$app->params['adminEmail'])
                ->setSubject("Test mail from {$host}")
                ->setTextBody($content)
                ->send();
        } else {
            return false;
        }
    }

}
