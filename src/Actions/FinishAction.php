<?php
namespace TaskForce\Actions;

use TaskForce\Main\Tasks;

class FinishAction extends AbstractAction
{
    public static function getName() :string
    {
        return 'Завершить';
    }

    public static function getInternalName() :string
    {
        return 'finish';
    }

    public static function checkAccess(int $userId, string $userRole, Tasks $task) :bool
    {
        return $userId === $task->getOwnerId() && $task->getStatus() === Tasks::STATUS_PROCESSING;
    }
}
