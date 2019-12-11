<?php

/**
 * @var $this yii\web\View
 * @var $task frontend\models\Tasks
 */

use yii\helpers\Html;

$this->title = 'TaskForce Просмотр задания';
Yii::$app->formatter->language = 'ru-RU';
?>

<section class="content-view">
    <div class="content-view__card">
        <div class="content-view__card-wrapper">
            <div class="content-view__header">
                <div class="content-view__headline">
                    <h1><?= Html::encode($task->name); ?></h1>
                    <span>Размещено в категории
                                    <a href="#" class="link-regular"><?= Html::encode($task->category->name); ?></a>
                                    <?= Yii::$app->formatter->asRelativeTime($task->created_at); ?></span>
                </div>
                <b class="new-task__price new-task__price--<?= Html::encode($task->category->icon); ?> content-view-price"><?= Html::encode($task->budget); ?>
                    <b> ₽</b></b>
                <div
                    class="new-task__icon new-task__icon--<?= Html::encode($task->category->icon); ?> content-view-icon"></div>
            </div>
            <div class="content-view__description">
                <h3 class="content-view__h3">Общее описание</h3>
                <p>
                    <?= Html::encode($task->description); ?>
                </p>
            </div>
            <div class="content-view__attach">
                <h3 class="content-view__h3">Вложения</h3>
                <?php foreach ($task->taskFiles as $file) : ?>
                    <a href="#"><?= Html::encode($file->file); ?></a>
                <?php endforeach; ?>
            </div>
            <div class="content-view__location">
                <h3 class="content-view__h3">Расположение</h3>
                <div class="content-view__location-wrapper">
                    <div class="content-view__map">
                        <a href="#"><img src="/img/map.jpg" width="361" height="292"
                                         alt="Москва, Новый арбат, 23 к. 1"></a>
                    </div>
                    <div class="content-view__address">
                        <span class="address__town">Москва</span><br>
                        <span>Новый арбат, 23 к. 1</span>
                        <p>Вход под арку, код домофона 1122</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-view__action-buttons">
            <button class=" button button__big-color response-button"
                    type="button">Откликнуться
            </button>
            <button class="button button__big-color refusal-button"
                    type="button">Отказаться
            </button>
            <button class="button button__big-color connection-button"
                    type="button">Написать сообщение
            </button>
        </div>
    </div>
    <div class="content-view__feedback">
        <?php $responses = $task->responses; ?>
        <h2>Отклики <span>(<?= count($responses); ?>)</span></h2>
        <div class="content-view__feedback-wrapper">
            <?php foreach ($responses as $response): ?>
                <div class="content-view__feedback-card">
                    <div class="feedback-card__top">
                        <a href="#"><img src="<?= $response->user->userProfile->avatar; ?>" width="55" height="55"></a>
                        <div class="feedback-card__top--name">
                            <p><a href="#" class="link-regular"><?= $response->user->name ?></a></p>
                            <?php $responserRating = $response->user->userRating; ?>
                            <?= $response->user->getUserRatingHtml($responserRating); ?>
                            <b><?= $responserRating; ?></b>
                        </div>
                        <span
                            class="new-task__time"><?= Yii::$app->formatter->asRelativeTime($response->created_at); ?></span>
                    </div>
                    <div class="feedback-card__content">
                        <p>
                            <?= Html::encode($response->comment); ?>
                        </p>
                        <span><?= Html::encode($response->price); ?> ₽</span>
                    </div>
                    <div class="feedback-card__actions">
                        <button class="button__small-color response-button button"
                                type="button">Откликнуться
                        </button>
                        <button class="button__small-color refusal-button button"
                                type="button">Отказаться
                        </button>
                        <button class="button__chat button"
                                type="button"></button>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<section class="connect-desk">
    <div class="connect-desk__profile-mini">
        <div class="profile-mini__wrapper">
            <h3>Заказчик</h3>
            <div class="profile-mini__top">
                <img src="<?= $task->ownerUser->userProfile->avatar; ?>" width="62" height="62" alt="Аватар заказчика">
                <div class="profile-mini__name five-stars__rate">
                    <p><?= Html::encode($task->ownerUser->name); ?></p>
                    <?php $ownerRating = $task->ownerUser->getUserRating(); ?>
                    <?= $task->ownerUser->getUserRatingHtml($ownerRating); ?>
                    <b><?= Html::encode($ownerRating); ?></b>
                </div>
            </div>
            <p class="info-customer"><span><?= Html::encode($task->ownerUser->userReviewsCountFormatted); ?></span><span
                    class="last-"><?= Html::encode($task->ownerUser->userTasksCountFormatted); ?></span></p>
            <a href="#" class="link-regular">Смотреть профиль</a>
        </div>
    </div>
    <div class="connect-desk__chat">
        <h3>Переписка</h3>
        <div class="chat__overflow">
            <div class="chat__message chat__message--out">
                <p class="chat__message-time">10.05.2019, 14:56</p>
                <p class="chat__message-text">Привет. Во сколько сможешь
                    приступить к работе?</p>
            </div>
            <div class="chat__message chat__message--in">
                <p class="chat__message-time">10.05.2019, 14:57</p>
                <p class="chat__message-text">На задание
                    выделены всего сутки, так что через час</p>
            </div>
            <div class="chat__message chat__message--out">
                <p class="chat__message-time">10.05.2019, 14:57</p>
                <p class="chat__message-text">Хорошо. Думаю, мы справимся</p>
            </div>
        </div>
        <p class="chat__your-message">Ваше сообщение</p>
        <form class="chat__form">
            <textarea class="input textarea textarea-chat" rows="2" name="message-text"
                      placeholder="Текст сообщения"></textarea>
            <button class="button chat__button" type="submit">Отправить</button>
        </form>
    </div>
</section>
