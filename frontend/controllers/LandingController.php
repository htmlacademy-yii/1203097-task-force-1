<?php
namespace frontend\controllers;

use yii\web\Controller;
use frontend\models\Tasks;
use Yii;
use frontend\models\FormLogin;
use yii\widgets\ActiveForm;
use yii\web\Response;

class LandingController extends Controller
{
    public function actionIndex()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->redirect(['/tasks']);
        }

        $this->layout = 'landing';
        $model = new FormLogin();

        if (Yii::$app->request->getIsPost()) {
            $model->load(Yii::$app->request->post());

            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;

                return ActiveForm::validate($model);
            }
            if ($model->validate()) {
                $user = $model->getUser();
                \Yii::$app->user->login($user);

                return $this->goHome();
            }
        }

        $this->view->params['model'] = $model;
        $newTasks = Tasks::find()
            ->joinWith('category')
            ->orderBy(['created_at' => SORT_DESC])
            ->limit(4)
            ->all();
        return $this->render('index', [
            'newTasks' => $newTasks,
        ]);
    }

    public function actionLogout()
    {
        \Yii::$app->user->logout();

        return $this->goHome();
    }
}
