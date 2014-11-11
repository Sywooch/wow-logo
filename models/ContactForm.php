<?php

namespace app\models;

use Yii;
use yii\base\Model;

class ContactForm extends Model
{
    public $email;
    public $body;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['email', 'body'], 'required'],
            ['email', 'email'],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'email' => Yii::t('app', 'E-mail'),
            'body' => Yii::t('app', 'Ваш вопрос'),
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     * @param  string  $email the target email address
     * @return boolean whether the model passes validation
     */
    public function contact($email)
    {
        if ($this->validate()) {
            Yii::$app->mailer->compose()
                ->setTo($email)
                ->setFrom($this->email)
                ->setSubject(Yii::t('app', 'Вопрос с Главной страницы CreativeLogo'))
                ->setTextBody($this->body)
                ->send();
            return true;
        } else {
            return false;
        }
    }
}
