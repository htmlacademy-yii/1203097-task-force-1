<?php
namespace TaskForce\Actions;

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

    public static function checkAccess(int $userId, string $userRole, AvailableActions $strategy) :bool
    {
        return $userId === $strategy->getPerformerId() && $strategy->getStatus() === AvailableActions::STATUS_PROCESSING;
    }
}
