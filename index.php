<?php
use TaskForce\Main\Tasks;
require_once 'vendor/autoload.php';
// пример задачи
$attributes = [
    'taskId' => 1,
    'status' => Tasks::STATUS_NEW,
    'ownerId' => 2,
    'performerId' => null,
    'name' => "Сделать сайт",
    'description' => "Сделать простой лендинг",
    'categoryId' => 1,
    'cityId' => 1,
    'coordinates' => [],
    'budget' => 1000,
    'files' => null,
    'dateClose' => '31.12.2019'
];
$task = Tasks::createTask($attributes);
//var_dump($task);
assert($task->getNextStatus(TASKS::ACTION_ACCEPT) == TASKS::STATUS_PROCESSING, 'accept action');
assert($task->getNextStatus(TASKS::ACTION_CANCEL) == TASKS::STATUS_CANCELLED, 'cancel action');
assert($task->getNextStatus(TASKS::ACTION_REFUSE) == TASKS::STATUS_FAILED, 'refuse action');
assert($task->getNextStatus(TASKS::ACTION_FINISH) == TASKS::STATUS_COMPLETED, 'finish action');