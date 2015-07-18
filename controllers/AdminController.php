<?php

namespace app\controllers;


use app\models\AddAdminForm;
use app\models\LoginForm;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

class AdminController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => array(
                'class' => VerbFilter::className(),
                'actions' => array(
                    'logout' => array('post'),
                ),
            ),
        ];
    }

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionAddAdmin() {
        $model = new AddAdminForm();
        if ($model->load(Yii::$app->request->post()) && $model->add()) {
            return $this->goBack();
        } else {
            return $this->render('add-admin', [
                'model' => $model,
            ]);
        }
    }
}