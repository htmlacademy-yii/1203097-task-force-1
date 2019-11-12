<?php
use TaskForce\Main\Tasks;
use TaskForce\Actions\AcceptAction;
use TaskForce\Actions\CancelAction;
use TaskForce\Actions\FinishAction;
use TaskForce\Actions\RefuseAction;
use TaskForce\Actions\RespondAction;
use TaskForce\Actions\ChatAction;

require_once 'vendor/autoload.php';
// пример задачи
$attributes = [
    'taskId' => 1,
    'status' => Tasks::STATUS_NEW,
    'ownerId' => 1,
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
assert($task->getNextStatus(AcceptAction::class) == Tasks::STATUS_PROCESSING, 'accept action');
assert($task->getNextStatus(CancelAction::class) == Tasks::STATUS_CANCELLED, 'cancel action');
assert($task->getNextStatus(RefuseAction::class) == Tasks::STATUS_FAILED, 'refuse action');
assert($task->getNextStatus(FinishAction::class) == Tasks::STATUS_COMPLETED, 'finish action');

//Новая задача, id заказчика 1
assert($task->getAvailableActions(1, Tasks::ROLE_OWNER) === [TaskForce\Actions\AcceptAction::class, TaskForce\Actions\CancelAction::class], 'Заказчик может отменить или принять');
assert($task->getAvailableActions(2, Tasks::ROLE_PERFORMER) === [TaskForce\Actions\RespondAction::class], 'Исполнитель может откликнуться');
assert($task->getAvailableActions(2, Tasks::ROLE_OTHER) === [], 'Другие ничего не могут');

//Задача выполняется, исполнитель id 2
$task->setStatus(Tasks::STATUS_PROCESSING);
$task->setPerformerId(2);
assert($task->getAvailableActions(1, Tasks::ROLE_OWNER) === [TaskForce\Actions\FinishAction::class, TaskForce\Actions\ChatAction::class], 'Заказчику доступны чат и завершение задачи');
assert($task->getAvailableActions(2, Tasks::ROLE_PERFORMER) === [TaskForce\Actions\RefuseAction::class, TaskForce\Actions\ChatAction::class], 'Исполнителю доступны чат и отказ от задачи');

//Задача провалена
// TODO: может ли заказчик брать новых исполнителей на проваленные задачи?
$task->setStatus(Tasks::STATUS_FAILED);
assert($task->getAvailableActions(1, Tasks::ROLE_OWNER) === [], 'Заказчику ничего недоступно');
assert($task->getAvailableActions(2, Tasks::ROLE_PERFORMER) === [], 'Исполнителю ничего недоступно');
