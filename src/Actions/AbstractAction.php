<?php
namespace TaskForce\Actions;

use TaskForce\Main\Tasks;

abstract class AbstractAction
{
    abstract public static function getName() :string;

    abstract public static function getInternalName() :string;

    abstract public static function checkAccess(int $userId, string $userRole, Tasks $task) :bool;
}
