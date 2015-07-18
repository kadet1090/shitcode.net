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

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['email'], 'email'],
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
            if($admin->save()) {
                $content = <<<MAIL
Someone gave you admin access on happycode.io
You can use this mail and password $password to login.
MAIL;

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
