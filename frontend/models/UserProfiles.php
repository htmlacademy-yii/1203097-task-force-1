<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "user_profiles".
 *
 * @property int $id
 * @property int $user_id
 * @property string $address
 * @property string $birthday
 * @property string $information
 * @property string $avatar
 * @property int $city_id
 * @property string $last_online_at
 * @property int $notify_new_message
 * @property int $notify_task_action
 * @property int $notify_new_review
 * @property int $is_hidden
 * @property string $contact_phone
 * @property string $contact_skype
 * @property string $contact_other
 * @property int $views_count
 *
 * @property Users $user
 * @property Cities $city
 */
class UserProfiles extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_profiles';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'city_id'], 'required'],
            [['user_id', 'city_id', 'notify_new_message', 'notify_task_action', 'notify_new_review', 'is_hidden', 'views_count'], 'integer'],
            [['birthday', 'last_online_at'], 'safe'],
            [['information'], 'string'],
            [['address', 'avatar', 'contact_phone', 'contact_skype', 'contact_other'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cities::className(), 'targetAttribute' => ['city_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'address' => 'Address',
            'birthday' => 'Birthday',
            'information' => 'Information',
            'avatar' => 'Avatar',
            'city_id' => 'City ID',
            'last_online_at' => 'Last Online At',
            'notify_new_message' => 'Notify New Message',
            'notify_task_action' => 'Notify Task Action',
            'notify_new_review' => 'Notify New Review',
            'is_hidden' => 'Is Hidden',
            'contact_phone' => 'Contact Phone',
            'contact_skype' => 'Contact Skype',
            'contact_other' => 'Contact Other',
            'views_count' => 'Views Count',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(Cities::className(), ['id' => 'city_id']);
    }
}
