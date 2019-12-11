<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $created_at
 *
 * @property ChatMessages[] $chatMessages
 * @property Notifications[] $notifications
 * @property Responses[] $responses
 * @property Reviews[] $reviews
 * @property Reviews[] $reviewsByPerformer
 * @property Tasks[] $tasks
 * @property Tasks[] $tasks0
 * @property UserCategories[] $userCategories
 * @property UserFavorites[] $userFavorites
 * @property UserFavorites[] $userFavorites0
 * @property UserJobPhotos[] $userJobPhotos
 * @property UserProfiles[] $userProfile
 */
class Users extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'email'], 'required'],
            [['password'], 'string'],
            [['created_at'], 'safe'],
            [['name', 'email'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'email' => 'Email',
            'password' => 'Password',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChatMessages()
    {
        return $this->hasMany(ChatMessages::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNotifications()
    {
        return $this->hasMany(Notifications::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResponses()
    {
        return $this->hasMany(Responses::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReviews()
    {
        return $this->hasMany(Reviews::className(), ['owner_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReviewsByPerformer()
    {
        return $this->hasMany(Reviews::className(), ['performer_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTasks()
    {
        return $this->hasMany(Tasks::className(), ['owner_user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTasks0()
    {
        return $this->hasMany(Tasks::className(), ['performer_user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserCategories()
    {
        return $this->hasMany(UserCategories::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserFavorites()
    {
        return $this->hasMany(UserFavorites::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserFavorites0()
    {
        return $this->hasMany(UserFavorites::className(), ['favorite_user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserJobPhotos()
    {
        return $this->hasMany(UserJobPhotos::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserProfile()
    {
        return $this->hasOne(UserProfiles::class, ['user_id' => 'id']);
    }

    /**
     * @return float
     */
    public function getUserRating()
    {
        return number_format($this->getReviewsByPerformer()->average('score'),2);
    }

    /**
     * @param float $rating
     * @return string
     */
    public function getUserRatingHtml(float $rating)
    {
        $result = '';
        for ($i = 1; $i <= 5; $i += 1) {
            $result .= ($i <= $rating) ? '<span></span>' : '<span class="star-disabled"></span>';
        }

        return $result;
    }

    /**
     * @return int
     */
    public function getUserReviewsCount()
    {
        return $this->getReviewsByPerformer()->count();
    }

    /**
     * @return string
     */
    public function getUserReviewsCountFormatted()
    {
        return Yii::$app->i18n->format('{n, plural, =0{# отзывов} =1{# отзыв} one{# отзыв} few{# отзыва} many{# отзывов} other{# отзывов}}', ['n' => $this->getUserReviewsCount()], 'ru_RU');
    }

    /**
     * @return int
     */
    public function getUserTasksCount()
    {
        return $this->getTasks()->count();
    }

    /**
     * @return string
     */
    public function getUserTasksCountFormatted()
    {
        return Yii::$app->i18n->format('{n, plural, =0{# заказов} =1{# заказ} one{# заказ} few{# заказа} many{# заказов} other{# заказов}}', ['n' => $this->getUserTasksCount()], 'ru_RU');
    }
}
