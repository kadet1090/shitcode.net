<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 */
class AddAdminForm extends Model
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
     * Logs in a user using the provided username and password.
     * @return boolean whether the user is logged in successfully
     */
    public function add()
    {
        if ($this->validate()) {
            $password = Yii::$app->security->generateRandomString(12); // generate random password

            $admin = new Admin([
                'email' => $this->email,
                'password' => Yii::$app->security->generatePasswordHash($password)
            ]);

            $admin->link('createdBy', Yii::$app->user->identity);

            $host = Yii::$app->request->serverName;

            if($admin->save()) {
                $content = <<<MAIL
Someone gave you admin access on {$host}.
You can now log in using:
Email: {$this->email}
Password: $password

You can change this generated password if you only want.
MAIL;
                if(!empty($this->message)) {
                    $content .= PHP_EOL.PHP_EOL.'PS '.$this->message;
                }

                Yii::$app->mailer
                    ->compose()
                    ->setTo($this->email)
                    ->setFrom(Yii::$app->params['adminEmail'])
                    ->setSubject("Admin account on happycode was created for you")
                    ->setTextBody($content)
                    ->send();

                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

}
