<?php
namespace TaskForce\Actions;

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

    public static function checkAccess(int $userId, string $userRole, AvailableActions $strategy) :bool
    {
        return $userId === $strategy->getOwnerId() && $strategy->getStatus() === AvailableActions::STATUS_PROCESSING;
    }
}
