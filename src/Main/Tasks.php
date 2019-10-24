<?php
namespace TaskForce\Main;

class Tasks
{
    const STATUS_NEW = 'new';
    const STATUS_PROCESSING = 'processing';
    const STATUS_CANCELLED = 'cancelled';
    const STATUS_COMPLETED = 'completed';
    const STATUS_FAILED = 'failed';

    const ACTION_RESPOND = 'respond';
    const ACTION_ACCEPT = 'accept';
    const ACTION_CANCEL = 'cancel';
    const ACTION_REFUSE = 'refuse';
    const ACTION_FINISH = 'finish';
    const ACTION_CHAT = 'chat';
    const ACTION_ADD = 'add';

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
    private $coordinates = array();
    private $budget;
    private $files;
    private $dateClose;
    private $errors = array();

    private function __construct($taskId, $status, $ownerId, $performedId, $name, $description, $categoryId, $cityId, $coordinates, $budget, $files, $dateClose)
    {
        $this->taskId = $taskId;

        if (in_array($status, $this->getStatuses())) {
            $this->status = $status;
        } else {
            $this->status = self::STATUS_NEW;
        }

        $this->ownerId = $ownerId;
        $this->performerId = $performedId;
        $this->name = $name;
        $this->description = $description;
        $this->categoryId = $categoryId;
        $this->cityId = $cityId;
        $this->coordinates = $coordinates;
        $this->budget = $budget;
        $this->files = $files;
        $this->dateClose = $dateClose;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function getStatuses()
    {
        return array(
            self::STATUS_NEW,
            self::STATUS_PROCESSING,
            self::STATUS_CANCELLED,
            self::STATUS_COMPLETED,
            self::STATUS_FAILED,
        );
    }

    public function getActions()
    {
        return array(
            self::ACTION_RESPOND,
            self::ACTION_ACCEPT,
            self::ACTION_CANCEL,
            self::ACTION_REFUSE,
            self::ACTION_FINISH,
            self::ACTION_CHAT,
            self::ACTION_ADD,
        );
    }

    public function getNextStatus($action)
    {
        // TODO: нет проверок на доступность указанного действия
        if (!in_array($action, $this->getActions())) {
            throw new Exception('unknown action');
        }
        switch ($action) {
            case self::ACTION_ADD:
                $status = self::STATUS_NEW;
                break;
            case self::ACTION_ACCEPT:
                $status = self::STATUS_PROCESSING;
                break;
            case self::ACTION_CANCEL:
                $status = self::STATUS_CANCELLED;
                break;
            case self::ACTION_REFUSE:
                $status = self::STATUS_FAILED;
                break;
            case self::ACTION_FINISH:
                $status = self::STATUS_COMPLETED;
                break;
            default:
                $status = $this->status;
        }
        return $status;
    }

    public function getOwnerId()
    {
        return $this->ownerId;
    }

    public function getPerformerId()
    {
        return $this->performerId;
    }

    public function getAvailableActions($userId)
    {
        $actions = [];
        if ($this->getOwnerId() === $userId) {
            // действия для заказчика
            // TODO: accept должен быть только если есть отклики
            switch ($this->getStatus()) {
                case self::STATUS_NEW:
                    $actions = [self::ACTION_ACCEPT, self::ACTION_CANCEL];
                    break;
                case self::STATUS_PROCESSING:
                    $actions = [self::ACTION_FINISH, self::ACTION_CHAT];
                    break;
            }
        } else {
            // действия для исполнителей / исполнителя задания
            // TODO: добавить проверку что нельзя откликаться несколько раз
            switch ($this->getStatus()) {
                case self::STATUS_NEW:
                    $actions = [self::ACTION_RESPOND, self::ACTION_CHAT];
                    break;
                case self::STATUS_PROCESSING:
                    // отказ от задачи доступен только исполнителю задания
                    // TODO: если задание выполняется чат доступен только исполнителю задания?
                    if ($this->getPerformerId() === $userId) {
                        $actions = [self::ACTION_REFUSE, self::ACTION_CHAT];
                    }
                    break;
            }
        }
        return $actions;
    }

    public static function createTask($taskId, $status, $ownerId, $performedId, $name, $description, $categoryId, $cityId, $coordinates, $budget, $files, $dateClose)
    {
        // TODO: нужен ли taskId при создании или он будет как инкремент в базе?
        $taskObject = new Tasks($taskId, $status, $ownerId, $performedId, $name, $description, $categoryId, $cityId, $coordinates, $budget, $files, $dateClose);
        return $taskObject;
    }
}

?>
