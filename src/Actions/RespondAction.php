<?php
namespace TaskForce\Actions;

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

    public static function checkAccess(int $userId, string $userRole, AvailableActions $strategy) :bool
    {
        return $strategy->getStatus() === AvailableActions::STATUS_NEW && $strategy->getOwnerId() !== $userId && $userRole === AvailableActions::ROLE_PERFORMER;
    }
}
