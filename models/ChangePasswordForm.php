<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 */
class ChangePasswordForm extends Model
{
    public $password;
    public $repassword;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['password', 'repassword'], 'required'],
            [
                ['repassword'],
                'compare',
                'compareAttribute' => 'password'
            ],
        ];
    }

    /**
     * Returns the attribute labels.
     *
     * Attribute labels are mainly used for display purpose. For example, given an attribute
     * `firstName`, we can declare a label `First Name` which is more user-friendly and can
     * be displayed to end users.
     *
     * By default an attribute label is generated using [[generateAttributeLabel()]].
     * This method allows you to explicitly specify attribute labels.
     *
     * Note, in order to inherit labels defined in the parent class, a child class needs to
     * merge the parent labels with child labels using functions such as `array_merge()`.
     *
     * @return array attribute labels (name => label)
     * @see generateAttributeLabel()
     */
    public function attributeLabels()
    {
        return [
            'password' => Yii::t('happycode', 'New Password'),
            'repassword' => Yii::t('happycode', 'Repeat Password')
        ];
    }


    /**
     * Logs in a user using the provided username and password.
     * @return boolean whether the user is logged in successfully
     */
    public function change()
    {
        if ($this->validate()) {
            Yii::$app->user->identity->password = Yii::$app->security->generatePasswordHash($this->password);
            Yii::$app->user->identity->save();

            return true;
        } else {
            return false;
        }
    }

}
