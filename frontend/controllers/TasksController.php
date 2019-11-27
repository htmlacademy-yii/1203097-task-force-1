<?php

namespace frontend\controllers;

namespace frontend\controllers;

use frontend\models\ResendVerificationEmailForm;
use frontend\models\VerifyEmailForm;
use Yii;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use yii\db\Query;
use frontend\models\Users;
use frontend\models\UserProfiles;
use frontend\models\Tasks;
use frontend\models\Categories;

class TasksController extends Controller
{
    public function actionIndex()
    {
        $tasks = Tasks::find()
            ->where(['status' => 'new'])
            ->joinWith('category')
            ->joinWith('city')
            ->orderBy(['created_at' => SORT_DESC])
            ->all();

        return $this->render('index', [
            'tasks' => $tasks
        ]);
    }
}
