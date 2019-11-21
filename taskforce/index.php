<?php
use TaskForce\Actions\AvailableActions;
use TaskForce\Actions\AcceptAction;
use TaskForce\Actions\CancelAction;
use TaskForce\Actions\FinishAction;
use TaskForce\Actions\RefuseAction;
use TaskForce\Actions\RespondAction;
use TaskForce\Actions\ChatAction;

require_once '../vendor/autoload.php';

$strategy = new AvailableActions(AvailableActions::STATUS_NEW, 1 , null, '2019-12-31');

assert($strategy->getNextStatus(AcceptAction::class) === AvailableActions::STATUS_PROCESSING, 'accept action');
assert($strategy->getNextStatus(CancelAction::class) === AvailableActions::STATUS_CANCELLED, 'cancel action');
assert($strategy->getNextStatus(RefuseAction::class) === AvailableActions::STATUS_FAILED, 'refuse action');
assert($strategy->getNextStatus(FinishAction::class) === AvailableActions::STATUS_COMPLETED, 'finish action');

//Статус new, id заказчика 1
assert($strategy->getAvailableActions(1, AvailableActions::ROLE_OWNER) === [TaskForce\Actions\AcceptAction::class, TaskForce\Actions\CancelAction::class], 'Заказчик может отменить или принять');
assert($strategy->getAvailableActions(2, AvailableActions::ROLE_PERFORMER) === [TaskForce\Actions\RespondAction::class], 'Исполнитель может откликнуться');
assert($strategy->getAvailableActions(2, AvailableActions::ROLE_OTHER) === [], 'Другие ничего не могут');

//Статус processing, исполнитель id 2
$strategy = new AvailableActions(AvailableActions::STATUS_PROCESSING, 1 , 2, '2019-12-31');
assert($strategy->getAvailableActions(1, AvailableActions::ROLE_OWNER) === [TaskForce\Actions\FinishAction::class, TaskForce\Actions\ChatAction::class], 'Заказчику доступны чат и завершение задачи');
assert($strategy->getAvailableActions(2, AvailableActions::ROLE_PERFORMER) === [TaskForce\Actions\RefuseAction::class, TaskForce\Actions\ChatAction::class], 'Исполнителю доступны чат и отказ от задачи');

//Статус failed
$strategy = new AvailableActions(AvailableActions::STATUS_FAILED, 1 , 2, '2019-12-31');
assert($strategy->getAvailableActions(1, AvailableActions::ROLE_OWNER) === [], 'Заказчику ничего недоступно');
assert($strategy->getAvailableActions(2, AvailableActions::ROLE_PERFORMER) === [], 'Исполнителю ничего недоступно');
