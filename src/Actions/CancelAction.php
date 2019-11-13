<?php
namespace TaskForce\Actions;

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

    public static function checkAccess(int $userId, string $userRole, AvailableActions $strategy) :bool
    {
        return $userId === $strategy->getOwnerId() && $strategy->getStatus() === AvailableActions::STATUS_NEW;
    }
}
