<?php

namespace app\controllers;


use app\helpers\AlertHelper;
use app\models\AddAdminForm;
use app\models\Admin;
use app\models\ChangePasswordForm;
use app\models\Code;
use app\models\LoginForm;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class AdminController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only'  => ['logout', 'add-admin', 'admins', 'pending', 'change-status'],
                'rules' => [
                    [
                        'allow'   => true,
                        'roles'   => ['@'],
                    ],
                ],
            ],
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

    public function actionAddAdmin()
    {
        $model = new AddAdminForm();
        if ($model->load(Yii::$app->request->post()) && $model->add()) {
            AlertHelper::appendAlert('success', Yii::t('happycode', 'Added {email} to administrators.', ['email' => $model->email]));
            return $this->goBack();
        } else {
            return $this->render('add-admin', [
                'model' => $model,
            ]);
        }
    }

    public function actionAdmins()
    {
        $query  = Admin::find()->with('createdBy');
        $admins = new ActiveDataProvider([
            'query' => $query
        ]);

        return $this->render('admins', [
            'admins' => $admins,
        ]);
    }

    public function actionPending() {
        $query = Code::find()->where(['approved' => false]);
        $pending = new ActiveDataProvider([
            'query' => $query
        ]);

        return $this->render('pending', [
            'pending' => $pending,
        ]);
    }
    
    public function actionChangeStatus() {
        $id     = Yii::$app->request->getQueryParam('id');
        $status = Yii::$app->request->getQueryParam('status');

        $code = Code::findOne($id);
        if($code == null) throw new NotFoundHttpException(Yii::t('happycode', 'Given ID was not found in database.'));

        $code->approved = $status;
        $code->save();

        $message = Yii::t('happycode', $status == 1 ?
            'Paste <strong>#{id}</strong> was successfully approved.' :
            'Paste <strong>#{id}</strong> was successfully declined.',
            ['id' => $id]
        );

        if(Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            return [
                'id' => $id,
                'status' => $status,
                'message' => $message
            ];
        } else {
            AlertHelper::appendAlert('success', $message);
            return $this->redirect(['admin/pending']);
        }
    }

    public function actionChangePassword() {
        $model = new ChangePasswordForm();
        if ($model->load(Yii::$app->request->post()) && $model->change()) {
            AlertHelper::appendAlert('success', Yii::t('happycode', 'Your password was changed.'));
            return $this->goBack();
        } else {
            return $this->render('change-password', [
                'model' => $model,
            ]);
        }
    }
    
    /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {
        // Update last access
        if(!Yii::$app->user->isGuest) {
            Yii::$app->user->identity->last_access = date('Y-m-d H:i:s');
            Yii::$app->user->identity->save();
        }

        return parent::beforeAction($action);
    }


}