<?php
namespace TaskForce\Actions;

use TaskForce\Exceptions\TaskForceException;

class AvailableActions
{
    const STATUS_NEW = 'new';
    const STATUS_PROCESSING = 'processing';
    const STATUS_CANCELLED = 'cancelled';
    const STATUS_COMPLETED = 'completed';
    const STATUS_FAILED = 'failed';

    const STATUSES = [
        self::STATUS_NEW,
        self::STATUS_PROCESSING,
        self::STATUS_CANCELLED,
        self::STATUS_COMPLETED,
        self::STATUS_FAILED,
    ];

    const ACTIONS = [
        RespondAction::class,
        AcceptAction::class,
        CancelAction::class,
        RefuseAction::class,
        FinishAction::class,
        ChatAction::class,
    ];

    const ACTION_STATUS_MAP = [
        AcceptAction::class => self::STATUS_PROCESSING,
        CancelAction::class => self::STATUS_CANCELLED,
        RefuseAction::class => self::STATUS_FAILED,
        FinishAction::class => self::STATUS_COMPLETED,
    ];

    const ROLE_OWNER = 'owner';
    const ROLE_PERFORMER = 'performer';
    const ROLE_OTHER = 'other';

    const ROLES = [
        self::ROLE_OWNER,
        self::ROLE_PERFORMER,
        self::ROLE_OTHER,
    ];

    private $status;
    private $ownerId;
    private $performerId;
    private $dateClose;

    public function __construct(string $status, int $ownerId, ?int $performerId, string $dateClose)
    {
        if (!in_array($status, self::STATUSES)) {
            throw new TaskForceException('unknown status');
        }

        if ($ownerId < 0 || $performerId < 0) {
            throw new TaskForceException('ownerId and performerId can\'t be < 0');
        }

        $this->status = $status;
        $this->ownerId = $ownerId;
        $this->performerId = $performerId;
        $this->dateClose = $dateClose;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getStatuses(): array
    {
        return self::STATUSES;
    }

    public function getActions(): array
    {
        return self::ACTIONS;
    }

    public function getOwnerId(): int
    {
        return $this->ownerId;
    }

    public function getPerformerId(): ?int
    {
        return $this->performerId;
    }

    public function getNextStatus(string $action): string
    {
        if (!in_array($action, $this->getActions())) {
            throw new TaskForceException('unknown action');
        }

        if (!class_exists($action)) {
            throw new TaskForceException('unknown class');
        }

        return self::ACTION_STATUS_MAP[$action] ?? $this->status;
    }

    public function getAvailableActions(int $userId, string $userRole): array
    {
        if (!in_array($userRole, self::ROLES)) {
            throw new TaskForceException('unknown user role');
        }

        foreach ($this->getActions() as $action) {
            if (!class_exists($action)) {
                throw new TaskForceException('unknown class');
            }

            if (!method_exists($action, 'checkAccess')) {
                throw new TaskForceException('unknown method');
            }

            if ($action::checkAccess($userId, $userRole, $this)) {
                $result[] = $action;
            }
        }

        return $result ?? [];
    }
}
