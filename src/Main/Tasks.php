<?php
namespace TaskForce\Main;

use TaskForce\Actions;

class Tasks
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
        Actions\RespondAction::class,
        Actions\AcceptAction::class,
        Actions\CancelAction::class,
        Actions\RefuseAction::class,
        Actions\FinishAction::class,
        Actions\ChatAction::class,
    ];

    const ACTION_STATUS_MAP = [
        Actions\AcceptAction::class => self::STATUS_PROCESSING,
        Actions\CancelAction::class => self::STATUS_CANCELLED,
        Actions\RefuseAction::class => self::STATUS_FAILED,
        Actions\FinishAction::class => self::STATUS_COMPLETED,
    ];

    const ROLE_OWNER = 'owner';
    const ROLE_PERFORMER = 'performer';
    const ROLE_OTHER = 'other';

    private $taskId;
    private $status;
    private $ownerId;
    private $performerId;
    private $name;
    private $description;
    private $categoryId;
    private $cityId;
    private $coordinates = [];
    private $budget;
    private $files;
    private $dateClose;
    private $errors = [];

    private function __construct(array $attributes)
    {
        foreach ($attributes as $attribute => $value) {
            if (property_exists($this, $attribute)) {
                $this->{$attribute} = $value;
            }
        }
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus($status): void
    {
       $this->status = $status;
    }

    public function getStatuses(): array
    {
        return self::STATUSES;
    }

    public function getActions(): array
    {
        return self::ACTIONS;
    }

    public function getNextStatus(string $action): string
    {
        if (!in_array($action, $this->getActions())) {
            throw new Exception('unknown action');
        }

        return self::ACTION_STATUS_MAP[$action] ?? $this->status;
    }

    public function getOwnerId(): int
    {
        return $this->ownerId;
    }

    public function isOwner(int $userId): bool
    {
        return $this->ownerId === $userId;
    }

    public function getPerformerId(): ?int
    {
        return $this->performerId;
    }

    public function setPerformerId(int $userId): void
    {
        $this->performerId = $userId;
    }

    public function isPerformer(int $userId): bool
    {
        return $this->performerId === $userId;
    }

    public function getAvailableActions(int $userId, string $userRole): array
    {
        // TODO: accept должен быть только если есть отклики
        // TODO: добавить проверку что нельзя откликаться несколько раз
        foreach ($this->getActions() as $action) {
            if ($action::checkAccess($userId, $userRole, $this)) {
                $result[] = $action;
            }
        }

        return $result ?? [];
    }

    public static function createTask(array $attributes): Tasks
    {
        $taskObject = new Tasks($attributes);

        return $taskObject;
    }
}
