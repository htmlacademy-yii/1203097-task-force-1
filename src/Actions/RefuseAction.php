<?php
namespace TaskForce\Actions;

use TaskForce\Main\Tasks;

class RefuseAction extends AbstractAction
{
    public static function getName() :string
    {
        return 'Отказаться';
    }

    public static function getInternalName() :string
    {
        return 'refuse';
    }

    public static function checkAccess(int $userId, string $userRole, Tasks $task) :bool
    {
        return $userId === $task->getPerformerId() && $task->getStatus() === Tasks::STATUS_PROCESSING;
    }
}
