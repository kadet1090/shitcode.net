<?php

namespace app\controllers;

use app\helpers\AlertHelper;
use app\models\AddCodeForm;
use app\models\Code;
use Yii;
use yii\data\ActiveDataProvider;
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
        return $this->_sorted('id', SORT_ASC);
    }

    public function actionLatest()
    {
        return $this->_sorted('id', SORT_DESC);
    }

    public function actionBest()
    {
        return $this->_sorted('score', SORT_ASC);
    }

    public function actionWorst()
    {
        return $this->_sorted('score', SORT_DESC);
    }

    private function _sorted($field, $sort) {
        $lang = Yii::$app->request->getQueryParam('language');

        $conditions = ['approved' => 1];
        if($lang)
            $conditions['language'] = $lang;

        $query = $field != 'score' ? Code::find() : Code::findWithScore();
        $query->where($conditions)->orderBy([$field => $sort]);

        $models = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => Yii::$app->params['per-page'],
            ],
        ]);

        return $this->render('index', [
            'models' => $models
        ]);
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

    public function actionPaste() {
        $id = Yii::$app->request->getQueryParam('id');
        $model = Code::findOne($id);

        return $this->render('paste', [
            'model' => $model,
        ]);
    }

    public function actionAbout()
    {
        return $this->render('about');
    }
}
