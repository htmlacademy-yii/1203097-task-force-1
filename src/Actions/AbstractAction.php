<?php
namespace TaskForce\Actions;

abstract class AbstractAction
{
    abstract public static function getName() :string;

    abstract public static function getInternalName() :string;

    abstract public static function checkAccess(int $userId, string $userRole, AvailableActions $strategy) :bool;
}
