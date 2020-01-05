<?php

/**
 * @var $this yii\web\View
 * @var $model frontend\models\FormSignup
 * @var $cities array of all cities in db
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'TaskForce Регистрация';
Yii::$app->formatter->language = 'ru-RU';

$this->registerCss(".has-error input {
 border-color: #FF116E; }
  .has-error input + .help-block {
    color: #FF116E; }
  .reg-fields {
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
  -webkit-box-orient: vertical;
  -webkit-box-direction: normal;
      -ms-flex-direction: column;
          flex-direction: column;
  }
    ");
?>

<section class="registration__user">
    <h1>Регистрация аккаунта</h1>
    <div class="registration-wrapper">

        <?php $form = ActiveForm::begin([
            'id' => 'form-signup',
            'options' => ['class' => 'registration__user-form form-create'],
            'enableClientValidation' => true,
            'validateOnSubmit' => true,
            'validateOnChange' => true,
            'fieldConfig' => [
                'options'         => [
                    'class' => 'reg-fields',
                ],
            ],

        ]); ?>

        <?= $form->field($model, 'email', [
            'template' => "{label}\n{input}\n{error}",
        ])->textInput([
            'class' => 'input textarea',
            'type' => 'email',
            'placeholder' => 'vasya@pupkin.ru',
        ]); ?>

        <?= $form->field($model, 'name', [
            'template' => "{label}\n{input}\n{error}",
        ])->textInput([
            'class' => 'input textarea',
            'placeholder' => 'Василий Пупкин',
        ]);?>

        <?= $form->field($model, 'city', [
        ])->dropDownList($cities, [
            'class' => 'multiple-select input town-select registration-town',
        ])->hint('Укажите город, чтобы находить подходящие задачи', ['tag' => 'span']); ?>

        <?= $form->field($model, 'password', [
            'template' => "{label}\n{input}\n{error}",
        ])->passwordInput(['class' => 'input textarea']); ?>

        <?= Html::submitButton('Cоздать аккаунт', ['class' => 'button button__registration']); ?>

        <?php ActiveForm::end(); ?>

    </div>
</section>
