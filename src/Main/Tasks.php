<?php
namespace TaskForce\Main;
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
    const ACTION_RESPOND = 'respond';
    const ACTION_ACCEPT = 'accept';
    const ACTION_CANCEL = 'cancel';
    const ACTION_REFUSE = 'refuse';
    const ACTION_FINISH = 'finish';
    const ACTION_CHAT = 'chat';
    const ACTION_ADD = 'add';
    const ACTIONS = [
        self::ACTION_RESPOND,
        self::ACTION_ACCEPT,
        self::ACTION_CANCEL,
        self::ACTION_REFUSE,
        self::ACTION_FINISH,
        self::ACTION_CHAT,
        self::ACTION_ADD,
    ];
    const ACTION_STATUS_MAP = [
        self::ACTION_ADD => self::STATUS_NEW,
        self::ACTION_ACCEPT => self::STATUS_PROCESSING,
        self::ACTION_CANCEL => self::STATUS_CANCELLED,
        self::ACTION_REFUSE => self::STATUS_FAILED,
        self::ACTION_FINISH => self::STATUS_COMPLETED,
    ];
    const ACTIONS_OWNER_MAP = [
        self::STATUS_NEW => [self::ACTION_ACCEPT, self::ACTION_CANCEL],
        self::STATUS_PROCESSING => [self::ACTION_FINISH, self::ACTION_CHAT]
    ];
    const ACTIONS_PERFORMER_MAP = [
        self::STATUS_PROCESSING => [self::ACTION_REFUSE, self::ACTION_CHAT]
    ];
    const ACTIONS_OTHER_MAP = [
        self::STATUS_NEW => [self::ACTION_RESPOND, self::ACTION_CHAT]
    ];
    const ROLE_OWNER = 'owner';
    const ROLE_PERFORMER = 'performer';
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
        // TODO: нет проверок на доступность указанного действия
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
    public function getPerformerId(): int
    {
        return $this->performerId;
    }
    public function isPerformer(int $userId): bool
    {
        return $this->performerId === $userId;
    }
    public function getAvailableActions(int $userId): ?array
    {
        // TODO: accept должен быть только если есть отклики
        // TODO: добавить проверку что нельзя откликаться несколько раз
        // TODO: если задание выполняется чат доступен только исполнителю задания?
        if ($this->isOwner($userId)) {
            return self::ACTIONS_OWNER_MAP[$this->getStatus()] ?? null;
        } 
        if ($this->isPerformer($userId)) {
            return self::ACTIONS_PERFORMER_MAP[$this->getStatus()] ?? null;
        } 
        return self::ACTIONS_OTHER_MAP[$this->getStatus()] ?? null;
    }
    public static function createTask(array $attributes): Tasks
    {
        // TODO: нужен ли taskId при создании или он будет как инкремент в базе?
         $taskObject = new Tasks($attributes);
         return $taskObject;
    }
}