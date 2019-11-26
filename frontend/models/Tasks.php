<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "tasks".
 *
 * @property int $id
 * @property string $status
 * @property int $owner_user_id
 * @property int $performer_user_id
 * @property string $name
 * @property string $description
 * @property int $category_id
 * @property int $city_id
 * @property double $lat
 * @property double $lng
 * @property int $budget
 * @property string $date_close
 * @property string $created_at
 * @property string $updated_at
 * @property string $address
 *
 * @property ChatMessages[] $chatMessages
 * @property Responses[] $responses
 * @property Reviews[] $reviews
 * @property TaskFiles[] $taskFiles
 * @property Categories $category
 * @property Cities $city
 * @property Users $ownerUser
 * @property Users $performerUser
 */
class Tasks extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tasks';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status', 'owner_user_id', 'name', 'description', 'category_id'], 'required'],
            [['status', 'description'], 'string'],
            [['owner_user_id', 'performer_user_id', 'category_id', 'city_id', 'budget'], 'integer'],
            [['lat', 'lng'], 'number'],
            [['date_close', 'created_at', 'updated_at'], 'safe'],
            [['name', 'address'], 'string', 'max' => 255],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categories::className(), 'targetAttribute' => ['category_id' => 'id']],
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cities::className(), 'targetAttribute' => ['city_id' => 'id']],
            [['owner_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['owner_user_id' => 'id']],
            [['performer_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['performer_user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'status' => 'Status',
            'owner_user_id' => 'Owner User ID',
            'performer_user_id' => 'Performer User ID',
            'name' => 'Name',
            'description' => 'Description',
            'category_id' => 'Category ID',
            'city_id' => 'City ID',
            'lat' => 'Lat',
            'lng' => 'Lng',
            'budget' => 'Budget',
            'date_close' => 'Date Close',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'address' => 'Address',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChatMessages()
    {
        return $this->hasMany(ChatMessages::className(), ['task_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResponses()
    {
        return $this->hasMany(Responses::className(), ['task_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReviews()
    {
        return $this->hasMany(Reviews::className(), ['task_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTaskFiles()
    {
        return $this->hasMany(TaskFiles::className(), ['task_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Categories::className(), ['id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(Cities::className(), ['id' => 'city_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOwnerUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'owner_user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPerformerUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'performer_user_id']);
    }
}
