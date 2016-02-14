<?php

namespace app\controllers;

use app\helpers\AlertHelper;
use app\models\AddCodeForm;
use app\models\Code;
use app\models\Vote;
use Yii;
use yii\base\InvalidParamException;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use app\models\ContactForm;
use yii\web\Response;

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
        return $this->_sorted('id', SORT_ASC, Yii::t('happycode', 'All'));
    }

    public function actionLatest()
    {
        return $this->_sorted('id', SORT_DESC, Yii::t('happycode', 'Latest'));
    }

    public function actionBest()
    {
        return $this->_sorted('score', SORT_DESC, Yii::t('happycode', 'Top Rated'));
    }

    public function actionWorst()
    {
        return $this->_sorted('score', SORT_ASC, Yii::t('happycode', 'Worst'));
    }

    private function _sorted($field, $sort, $action) {
        $lang = Yii::$app->request->getQueryParam('language');

        $conditions = ['approved' => 1];
        if($lang)
            $conditions['language'] = $lang;

        $query = Code::find();
        $query->where($conditions)->orderBy([$field => $sort]);

        $models = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => Yii::$app->params['per-page'],
            ],
        ]);

        return $this->render('index', [
            'models' => $models,
            'languages' => Code::getLanguages(),
            'action' => $action,
        ]);
    }

    public function actionVote() {
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
        }

        $id = Yii::$app->request->getQueryParam('id');
        $vote = Yii::$app->request->getQueryParam('vote');
        switch($vote) {
            case 'up':
                $v = 1;
                break;
            case 'down':
                $v = -1;
                break;
            default:
                throw new InvalidParamException('Vote must be up or down!');
        }

        $vote = new Vote([
            'vote' => $v,
            'ip' => ip2long(Yii::$app->request->userIP),
            'fingerprint' => md5(Yii::$app->request->userAgent),
            'snippet_id' => $id
        ]);

        if($vote->validate()) {
            $vote->save();
            $paste = Code::findOne($vote->snippet_id);

            $message = Yii::t('happycode', 'Voted!');
            if(Yii::$app->request->isAjax) {
                return [
                    'id' => $id,
                    'message' => $message,
                    'score' => $paste->score
                ];
            } else {
                AlertHelper::appendAlert('success', $message);
                return $this->goBack();
            }
        } else {
            Yii::$app->response->statusCode = 403;

            $message = Yii::t('happycode', 'Already voted on this paste.');
            if(Yii::$app->request->isAjax) {
                return [
                    'id' => $id,
                    'message' => $message,
                ];
            } else {
                AlertHelper::appendAlert('warning', $message);
                return $this->goBack();
            }
        }
    }

    public function actionSaveSettings() {
        $post = Yii::$app->request->post();

        if(isset($post['ace-style']))
            Yii::$app->userSettings->aceStyle  = $post['ace-style'];

        if(isset($post['highlight-style']))
            Yii::$app->userSettings->highlightStyle  = $post['highlight-style'];

        if(!Yii::$app->user->isGuest) {
            Yii::$app->user->identity->inform = (isset($post['inform']) && $post['inform'] == 'on') ? true : false;
            Yii::$app->user->identity->save();
        }

        AlertHelper::appendAlert('success', 'Settings saved successfully.');
        return $this->goBack();
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
