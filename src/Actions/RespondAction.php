<?php
namespace TaskForce\Actions;

use TaskForce\Main\Tasks;

class RespondAction extends AbstractAction
{
    public static function getName() :string
    {
        return 'Откликнуться';
    }

    public static function getInternalName() :string
    {
        return 'respond';
    }

    public static function checkAccess(int $userId, string $userRole, Tasks $task) :bool
    {
        return $task->getStatus() === Tasks::STATUS_NEW && $task->getOwnerId() !== $userId && $userRole === Tasks::ROLE_PERFORMER;
    }
}
