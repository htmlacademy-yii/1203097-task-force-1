<?php
namespace TaskForce\Actions;

class ChatAction extends AbstractAction
{
    public static function getName() :string
    {
        return 'Написать сообщение';
    }

    public static function getInternalName() :string
    {
        return 'chat';
    }

    public static function checkAccess(int $userId, string $userRole, AvailableActions $strategy) :bool
    {
        // TODO: нужна ли проверка что задание в статусе "выполняется" ?
        return $strategy->getPerformerId() && in_array($userId, [$strategy->getOwnerId(), $strategy->getPerformerId()]) && $strategy->getStatus() === AvailableActions::STATUS_PROCESSING;
    }
}
