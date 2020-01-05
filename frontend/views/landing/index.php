<?php

/**
 * @var $this yii\web\View
 * @var $newTasks array frontend\models\Tasks
 * array newTasks contains 4 last tasks and related category/city info
 * @var $model frontend\models\FormLogin
 */

use yii\helpers\Html;
use yii\helpers\BaseStringHelper;
use yii\widgets\ActiveForm;
use yii\bootstrap\Modal;

$this->title = 'TaskForce Лендинг';
Yii::$app->formatter->language = 'ru-RU';

$this->registerCss(".help-block { color: red; }");
$this->registerJsFile(
    '@web/validation-login.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);
?>

<?php if (Yii::$app->session->hasFlash('signup')): ?>
    <div class="alert alert-success alert-dismissable">
        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
        <h4><i class="icon fa fa-check"></i>
            <?= Yii::$app->session->getFlash('signup') ?>
        </h4>
    </div>
<?php endif; ?>

<!-- конфликт стилей с бутстрапом-->
<div class="landing-top" style="box-sizing:content-box">
    <h1>Работа для всех.<br>
        Найди исполнителя на любую задачу.</h1>
    <p>Сломался кран на кухне? Надо отправить документы? Нет времени самому гулять с собакой?
        У нас вы быстро найдёте исполнителя для любой жизненной ситуации?<br>
        Быстро, безопасно и с гарантией. Просто, как раз, два, три. </p>
    <button class="button">Создать аккаунт</button>
</div>
<div class="landing-center">
    <div class="landing-instruction">
        <div class="landing-instruction-step">
            <div class="instruction-circle circle-request"></div>
            <div class="instruction-description">
                <h3>Публикация заявки</h3>
                <p>Создайте новую заявку.</p>
                <p>Опишите в ней все детали
                    и  стоимость работы.</p>
            </div>
        </div>
        <div class="landing-instruction-step">
            <div class="instruction-circle  circle-choice"></div>
            <div class="instruction-description">
                <h3>Выбор исполнителя</h3>
                <p>Получайте отклики от мастеров.</p>
                <p>Выберите подходящего<br>
                    вам исполнителя.</p>
            </div>
        </div>
        <div class="landing-instruction-step">
            <div class="instruction-circle  circle-discussion"></div>
            <div class="instruction-description">
                <h3>Обсуждение деталей</h3>
                <p>Обсудите все детали работы<br>
                    в нашем внутреннем чате.</p>
            </div>
        </div>
        <div class="landing-instruction-step">
            <div class="instruction-circle circle-payment"></div>
            <div class="instruction-description">
                <h3>Оплата&nbsp;работы</h3>
                <p>По завершении работы оплатите
                    услугу и закройте задание</p>
            </div>
        </div>
    </div>
    <div class="landing-notice">
        <div class="landing-notice-card card-executor">
            <h3>Исполнителям</h3>
            <ul class="notice-card-list">
                <li>
                    Большой выбор заданий
                </li>
                <li>
                    Работайте где  удобно
                </li>
                <li>
                    Свободный график
                </li>
                <li>
                    Удалённая работа
                </li>
                <li>
                    Гарантия оплаты
                </li>
            </ul>
        </div>
        <div class="landing-notice-card card-customer">
            <h3>Заказчикам</h3>
            <ul class="notice-card-list">
                <li>
                    Исполнители на любую задачу
                </li>
                <li>
                    Достоверные отзывы
                </li>
                <li>
                    Оплата по факту работы
                </li>
                <li>
                    Экономия времени и денег
                </li>
                <li>
                    Выгодные цены
                </li>
            </ul>
        </div>
    </div>
</div>
<div class="landing-bottom">
    <div class="landing-bottom-container">
        <h2>Последние задания на сайте</h2>
        <?php foreach ($newTasks as $task):?>
        <div class="landing-task">
            <div class="landing-task-top task-<?= Html::encode($task->category->icon); ?>"></div>
            <div class="landing-task-description">
                <h3><a href="#" class="link-regular"><?= Html::encode($task->name); ?></a></h3>
                <p><?= BaseStringHelper::truncate(Html::encode($task->description), 80); ?></p>
            </div>
            <div class="landing-task-info">
                <div class="task-info-left">
                    <p><a href="#" class="link-regular"><?= Html::encode($task->category->name); ?></a></p>
                    <p><?= Yii::$app->formatter->asRelativeTime($task->created_at); ?></p>
                </div>
                <span><?= Html::encode($task->budget); ?> <b>₽</b></span>
            </div>
        </div>
        <?php endforeach; ?>

    </div>
    <div class="landing-bottom-container">
        <button onclick="window.location.href = '/tasks';" type="button" class="button red-button">смотреть все задания</button>
    </div>
</div>

<?php  Modal::begin([
    'id' => 'sign-in',
    'size' => 'modal-sm',
    'bodyOptions' => ['class' => 'form-modal'],
    'closeButton' => false,
    'header' => null,
]); ?>
<h2>Вход на сайт</h2>

<?php $form = ActiveForm::begin([
    'id' => 'form-login',
    'enableAjaxValidation' => false,
    'enableClientValidation' => false,

]); ?>
<p>
    <?= $form->field($model, 'email', [
        'template' => "{label}\n{input}\n{error}",
        'options' => [
            'tag' => false,
        ]
    ])->textInput([
        'class' => 'enter-form-email input input-middle',
        'type' => 'email',
    ])->label(null, ['class' => 'form-modal-description']);?>
</p>
<p>
    <?= $form->field($model, 'password', [
        'template' => "{label}\n{input}\n{error}",
        'options' => [
            'tag' => false,
        ]
    ])->textInput([
        'class' => 'enter-form-email input input-middle',
        'type' => 'password'
    ])->label(null, ['class' => 'form-modal-description']);
    ?>
</p>
<button class="button" type="submit">Войти</button>
<?php ActiveForm::end(); ?>

<button class="form-modal-close" data-dismiss="modal" type="button">Закрыть</button>
<?php  Modal::end(); ?>
