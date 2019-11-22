<?php
namespace TaskForce\Actions;

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

    public static function checkAccess(int $userId, string $userRole, AvailableActions $strategy) :bool
    {
        return $userId === $strategy->getOwnerId() && $strategy->getStatus() === AvailableActions::STATUS_NEW;
    }
}
