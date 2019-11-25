<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "reviews".
 *
 * @property int $id
 * @property int $task_id
 * @property int $owner_id
 * @property int $performer_id
 * @property string $message
 * @property int $score
 * @property int $task_completed
 * @property string $created_at
 *
 * @property Users $owner
 * @property Users $performer
 * @property Tasks $task
 */
class Reviews extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'reviews';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['task_id', 'owner_id', 'performer_id', 'task_completed'], 'required'],
            [['task_id', 'owner_id', 'performer_id', 'score', 'task_completed'], 'integer'],
            [['message'], 'string'],
            [['created_at'], 'safe'],
            [['owner_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['owner_id' => 'id']],
            [['performer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['performer_id' => 'id']],
            [['task_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tasks::className(), 'targetAttribute' => ['task_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'task_id' => 'Task ID',
            'owner_id' => 'Owner ID',
            'performer_id' => 'Performer ID',
            'message' => 'Message',
            'score' => 'Score',
            'task_completed' => 'Task Completed',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOwner()
    {
        return $this->hasOne(Users::className(), ['id' => 'owner_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPerformer()
    {
        return $this->hasOne(Users::className(), ['id' => 'performer_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTask()
    {
        return $this->hasOne(Tasks::className(), ['id' => 'task_id']);
    }
}
