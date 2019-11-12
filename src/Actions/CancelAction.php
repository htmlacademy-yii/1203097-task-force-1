<?php
namespace TaskForce\Actions;

use TaskForce\Main\Tasks;

class CancelAction extends AbstractAction
{
    public static function getName() :string
    {
        return 'Отменить';
    }

    public static function getInternalName() :string
    {
        return 'cancel';
    }

    public static function checkAccess(int $userId, string $userRole, Tasks $task) :bool
    {
        return $userId === $task->getOwnerId() && $task->getStatus() === Tasks::STATUS_NEW;
    }
}
