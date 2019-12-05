<?php

/**
 * @var $this yii\web\View
 * @var $tasks frontend\models\Tasks
 * array $tasks contains some tasks and related category/city info
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\ActiveField;

$this->title = 'TaskForce Новые задания';
Yii::$app->formatter->language = 'ru-RU';

?>
<section class="new-task">
    <div class="new-task__wrapper">
        <h1>Новые задания</h1>
        <?php foreach ($tasks as $task):?>
        <?php $taskLocation = isset($task->city->city_name) ? "{$task->city->city_name}, {$task->address}" : "Удаленная работа";?>
        <div class="new-task__card">
            <div class="new-task__title">
                <a href="#" class="link-regular"><h2><?= Html::encode($task->name); ?></h2></a>
                <a  class="new-task__type link-regular" href="#"><p><?= Html::encode($task->category->name); ?></p></a>
            </div>
            <div class="new-task__icon new-task__icon--<?= Html::encode($task->category->icon); ?>"></div>
            <p class="new-task_description">
                <?= Html::encode($task->description); ?>
            </p>
            <b class="new-task__price new-task__price--translation"><?= Html::encode($task->budget); ?><b> ₽</b></b>
            <p class="new-task__place"><?= Html::encode($taskLocation); ?></p>
            <span class="new-task__time"><?= Yii::$app->formatter->asRelativeTime($task->created_at); ?></span>
        </div>
        <?php endforeach; ?>
    </div>
    <div class="new-task__pagination">
        <ul class="new-task__pagination-list">
            <li class="pagination__item"><a href="#"></a></li>
            <li class="pagination__item pagination__item--current">
                <a>1</a></li>
            <li class="pagination__item"><a href="#">2</a></li>
            <li class="pagination__item"><a href="#">3</a></li>
            <li class="pagination__item"><a href="#"></a></li>
        </ul>
    </div>
</section>
<section  class="search-task">
    <div class="search-task__wrapper">
        <?php $form = ActiveForm::begin(['id' => 'search-task-form', 'options' => ['class' => 'search-task__form']]); ?>
        <fieldset class="search-task__categories">
            <legend>Категории</legend>
            <?php
            $itemsCategories = \yii\helpers\ArrayHelper::map(frontend\models\Categories::find()->all(), "id", "name");
            echo $form->field($model, 'categories', [
                'template' => "{input}\n{label}",
                'options' => [
                    'tag' => false,
                ],
            ])->checkboxList($itemsCategories, [
                'item' => function ($index, $label, $name, $checked, $value) {
                    $selected = $checked ? "checked" : "";
                    return "<input class='visually-hidden checkbox__input' type='checkbox' name='{$name}' id='category-{$index}' value='{$value}' {$selected}>\n<label for='category-{$index}'>{$label} </label>";
                }
            ])->label(false);
            ?>
        </fieldset>
        <fieldset class="search-task__categories">
            <legend>Дополнительно</legend>
            <?= $form->field($model, 'myCity', [
                'template' => "{input}\n{label}",
                'options' => [
                    'tag' => false,
                ]
            ])->checkbox([
                'class' => 'visually-hidden checkbox__input',
            ], false);
            ?>
            <?=
            $form->field($model, 'remoteWork', [
                'template' => "{input}\n{label}",
                'options' => [
                    'tag' => false,
                ]
            ])->checkbox([
                'class' => 'visually-hidden checkbox__input',
            ], false);
            ?>
        </fieldset>

        <?php
        $items = [
            'all' => 'За все время',
            'day' => 'За день',
            'week' => 'За неделю',
            'month' => 'За месяц',
        ];
        $params = [
            'class' => 'multiple-select input'
        ];
        //$params = [];
        echo $form->field($model, 'period', [
            'template' => "{label}\n{input}",
            'options' => [
                'tag' => false,
            ]
        ])->dropDownList($items, $params)->label(null, ['class' => 'search-task__name']);
        ?>

        <?= $form->field($model, 'searchName', [
            'template' => "{label}\n{input}",
            'options' => [
                'tag' => false,
            ]
        ])->textInput([
            'class' => 'input-middle input',
            'type' => 'search'
        ])->label(null, ['class' => 'search-task__name']);
        ?>

        <button class="button" type="submit">Искать</button>
        <?php ActiveForm::end(); ?>
    </div>
</section>
