<?php

namespace app\controllers;

use app\helpers\AlertHelper;
use app\models\AddCodeForm;
use Yii;
use yii\web\Controller;
use app\models\ContactForm;

class SiteController extends Controller
{
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    public function actionAdd()
    {
        $model = new AddCodeForm();
        if ($model->load(Yii::$app->request->post()) && $model->add()) {
            AlertHelper::appendAlert(
                'success',
                Yii::t('happycode', 'Your paste was successfully added and is currently waiting for administrator to approve it.')
            );

            return $this->redirect(['site/index']);
        } else {
            return $this->render('add-code', [
                'model' => $model,
            ]);
        }
    }

    public function actionAbout()
    {
        return $this->render('about');
    }
}
