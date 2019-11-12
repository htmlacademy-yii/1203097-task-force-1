<?php
namespace TaskForce\Actions;

use TaskForce\Main\Tasks;

class AcceptAction extends AbstractAction
{
    public static function getName() :string
    {
        return 'Принять';
    }

    public static function getInternalName() :string
    {
        return 'accept';
    }

    public static function checkAccess(int $userId, string $userRole, Tasks $task) :bool
    {
        return $userId === $task->getOwnerId() && $task->getStatus() === Tasks::STATUS_NEW;
    }
}
