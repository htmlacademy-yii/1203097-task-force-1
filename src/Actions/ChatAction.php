<?php
namespace TaskForce\Actions;

use TaskForce\Main\Tasks;

class ChatAction extends AbstractAction
{
    public static function getName() :string
    {
        return 'Написать сообщение';
    }

    public static function getInternalName() :string
    {
        return 'chat';
    }

    public static function checkAccess(int $userId, string $userRole, Tasks $task) :bool
    {
        // TODO: нужна ли проверка что задание в статусе "выполняется" ?
        return $task->getPerformerId() && in_array($userId, [$task->getOwnerId(), $task->getPerformerId()]) && $task->getStatus() === TASKS::STATUS_PROCESSING;
    }
}
