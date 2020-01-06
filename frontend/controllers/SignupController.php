<?php
namespace frontend\controllers;

use yii\web\Controller;
use yii;
use frontend\models\FormSignup;
use frontend\models\Cities;
use frontend\models\Users;
use frontend\models\UserProfiles;
use yii\base\ErrorException;

class SignupController extends Controller
{
    public function actionIndex()
    {
        $this->layout = 'landing';
        $cities = Cities::find()->select(['city_name', 'id'])->indexBy('id')->column();
        $form = new FormSignup();

        if (Yii::$app->request->getIsPost()) {
            $form->load(Yii::$app->request->post());

            if ($form->validate()) {
                $user = new Users();
                $user->password = Yii::$app->security->generatePasswordHash($form->password);
                $user->name = $form->name;
                $user->email = $form->email;
                $user->created_at = new \yii\db\Expression('NOW()');

                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    $isSuccess = false;
                    if ($user->save()) {
                        $profile = new UserProfiles();
                        $profile->user_id = $user->id;
                        $profile->city_id = $form->city;
                        $profile->avatar = '/img/circle-choice.png'; //TODO: default user's avatar
                        if ($profile->save()) {
                            $transaction->commit();
                            $isSuccess = true;
                            $session = Yii::$app->session;
                            $session->setFlash('signup', 'Вы успешно зарегистрированы.');
                            $this->goHome();
                        }
                    }
                    if (!$isSuccess) {
                        throw new ErrorException('Ошибка сохранения данных.');
                    }
                } catch(ErrorException $e) {
                    $transaction->rollback();
                }
            }
        }

        return $this->render('index', [
            'model' => $form,
            'cities' => $cities,
        ]);
    }
}
